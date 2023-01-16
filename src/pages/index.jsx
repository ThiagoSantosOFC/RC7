import Head from "next/head";

export default function Home() {
  return (
    <>
      <Head>
        <title>QuarkChat</title>
        <meta name="description" content="Fale com seus amigos" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="/assets/logo Quark.svg" />
      </Head>
      <div className="min-h-full min-w-full flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
        <div className="max-w-md w-full space-y-8">
          <div>
            <img
              className="mx-auto h-20 w-auto"
              src="/assets/logo Quark.svg"
              alt="QuarkChat"
            />
            <h2 className="mt-6 text-center text-3xl font-extrabold text-white">
              QuarkChat
            </h2>
            <p className="mt-2 text-center text-sm text-gray-200">
              Fale com seus amigos
            </p>
          </div>
       
          <div className="mt-8 space-y-6">
            <div className="rounded-md shadow">
              <a
                href="/login"
                className="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700"
              >
                Entrar
              </a>
            </div>

            <div className="rounded-md shadow">
              <a
                href="/register"
                className="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700"
              >
                Registrar
              </a>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
