import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import { useStateContext } from '@/context/contextProvider';
import { Toaster, toast } from 'react-hot-toast';
import axios from 'axios';

export default function Login({ status, canResetPassword }) {
  const { theme } = useStateContext();

  const { data, setData, post, processing, errors, reset } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const [twoFactorModeLoading, setTwoFactorModeLoading] = useState(false);
  const [twoFactorMode, setTwoFactorMode] = useState(false);
  const [twoFactorCode, setTwoFactorCode] = useState('');
  const [twoFactorError, setTwoFactorError] = useState('');

  const submit = (e) => {
    e.preventDefault();
    setTwoFactorModeLoading(true);

    axios.post(route('login'), data)
      .then(response => {
        if (response.data.twofa) {
          setTwoFactorMode(true);
          setTwoFactorModeLoading(false);
        } else {
          // fallback
          setTwoFactorModeLoading(false);
        }
      })
      .catch(error => {
        console.error(error)
        toast.error('Invalid email or password');
        setTwoFactorModeLoading(false);
      });
  };

  const handle2faSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post('/verify-2fa', {
        code: twoFactorCode,
      });

      if (response.data.success) {
        const T = response.data.user_type;
        if (T === 2050 || T === 2051 || T === 2052) {
          window.location.href = '/dashboard';
        } else if (T === 2053) {
          window.location.href = '/depot';
        } else if (T === 2054 || T === 2055) {
          window.location.href = '/tasks';
        }

      } else {
        toast.error(response.data.message);
      }
    } catch (error) {
      console.error(error);
      toast.error('Invalid or expired code.');
    }
  };

  const handleResendCode = async () => {
    try {
      const res = await axios.post('/resend-2fa');
      toast.success(res.data.message || 'Code resent');
    } catch (err) {
      toast.error(err.response?.data?.message || 'Failed to resend code.');
    }
  };

  return (
    <div className='h-screen flex md:flex-row flex-col' style={{ background: theme.background, color: theme.accent }}>
      <Head title="Log in" />
      <Toaster
        position="top-right"
        reverseOrder={false}
        toastOptions={{
          style: {
            padding: '18px',
            border: '1px solid',
            background: theme.background,
            color: theme.text,
            borderColor: theme.border,
          },
        }}
      />
      <div className='lg:w-3/5 h-screen py-1p lg:block hidden'>
        <div className='bus-bg bg-cover w-full h-full rounded-r-3xl'></div>
      </div>
      <div className='flex flex-col py-4 md:1/2 lg:w-2/5 w-full items-center'>
        <p className='font-bold lg:text-4xl text-2xl w-full text-center'>Bus Transportation Management System</p>
        <p className='font-semibold lg:text-3xl text-xl text-center mt-10'>Logistic I</p>

        <form
          onSubmit={twoFactorMode ? handle2faSubmit : submit}
          className='xl:w-4/6 lg:w-5/6 sm:w-2/3 py-4 rounded-3xl shadow-lg shad mt-10 flex flex-col items-center border'
          style={{ background: theme.background, color: theme.accent, borderColor: theme.border }}
        >
          <p className='text-center mb-4 text-xl'>{twoFactorMode ? 'Two-Factor Authentication' : 'Sign In'}</p>
          <hr className='border w-full' style={{ borderColor: theme.accent }} />

          {!twoFactorMode ? (
            <>
              <div className='mt-8 w-4/5'>
                <input
                  id="email"
                  type="email"
                  name="email"
                  value={data.email}
                  className="mt-1 block w-full bg-transparent rounded-md p-2"
                  style={{ borderColor: theme.border }}
                  autoComplete="username"
                  onChange={(e) => setData('email', e.target.value)}
                  placeholder="Email"
                />
                <InputError message={errors.email} className="mt-2" />
              </div>

              <div className="mt-4 w-4/5">
                <input
                  id="password"
                  type="password"
                  name="password"
                  value={data.password}
                  className="mt-1 block w-full bg-transparent rounded-md p-2"
                  style={{ borderColor: theme.border }}
                  autoComplete="current-password"
                  onChange={(e) => setData('password', e.target.value)}
                  placeholder="Password"
                />
                <InputError message={errors.password} className="mt-2" />
              </div>

              <div className="w-4/5 flex justify-between mt-4 lg:mb-12 mb-12">
                <label className="flex items-center">
                  <Checkbox
                    name="remember"
                    checked={data.remember}
                    onChange={(e) => setData('remember', e.target.checked)}
                  />
                  <span className="ms-2 text-sm">Remember me</span>
                </label>

                {canResetPassword && (
                  <Link
                    href={route('password.request')}
                    className="text-sm hover:text-gray-300 rounded-md"
                  >
                    Forgot your password?
                  </Link>
                )}
              </div>
            </>
          ) : (
            <>
              <div className="flex flex-col w-4/5 mt-8">
                <p className="text-sm mb-2">Enter the 6-digit code sent to your email.</p>
                <input
                  type="text"
                  value={twoFactorCode}
                  onChange={(e) => setTwoFactorCode(e.target.value)}
                  className="p-2 w-full rounded-md bg-transparent"
                  maxLength={6}
                  placeholder="XXXXXX"
                  style={{ borderColor: theme.border }}
                />
                {twoFactorError && <p className="text-red-500 text-sm mt-2">{twoFactorError}</p>}
              </div>

              <button
                type="button"
                onClick={handleResendCode}
                className="text-sm text-blue-500 hover:underline mt-2 self-end mr-10"
              >
                Resend Code
              </button>
            </>
          )}

          <div className="flex items-center mt-4 mb-8 w-4/5">
            <button
              type="submit"
              className="w-full font-medium p-2 rounded-md border disable"
              style={{ background: theme.accent, color: theme.background, borderColor: theme.border }}
              disabled={twoFactorModeLoading}
            >
              <p>{twoFactorMode ? 'Verify Code' : 'Log In'}</p>
            </button>
          </div>

          {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}
        </form>
      </div>
    </div>
  );
}
