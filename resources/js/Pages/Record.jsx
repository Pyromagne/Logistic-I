import useRole from "@/hooks/useRole";

const Record = ({ auth }) => {
    const { hasAccess, getLayout } = useRole();
    const Layout = getLayout(auth.user.type);

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Record" />
            <Layout user={auth.user} header={<NavHeader headerName="Record" />}>
              {!hasAccess(auth.user.type, [2050, 2051, 2052]) ? <Unauthorized /> :
                <div className="content">
                  
                </div>
              }
            </Layout>
        </AuthenticatedLayout>
    );
};

export default Record;
