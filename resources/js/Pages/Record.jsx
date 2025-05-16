import useRole from "@/hooks/useRole";
import { rnd_pdf_gen } from "@/functions/pdf_generators/rnd_pdf_gen";

const Record = ({ auth }) => {
    const { hasAccess, getLayout } = useRole();
    const Layout = getLayout(auth.user.type);

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Record" />
            <Layout user={auth.user} header={<NavHeader headerName="Record" />}>
              {!hasAccess(auth.user.type, [2050, 2051, 2052]) ? <Unauthorized /> :
                <div className="content" onClick={rnd_pdf_gen}>
                  <button className="btn">Export Receipt and Dispatch Data</button>
                </div>
              }
            </Layout>
        </AuthenticatedLayout>
    );
};

export default Record;
