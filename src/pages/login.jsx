import React from "react";
import Image from "next/image";
import Head from "next/head";
import { useState } from "react";
import { useRouter } from "next/router";

const login = () => {
const [email, setEmail] = useState("");
const [password, setPassword] = useState("");

const [error, setError] = useState("");

const router = useRouter();

const handleSubmit = async (e) => {
    e.preventDefault();

   //fetch with cors headers

    const res = await fetch("http://localhost/backend/user/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            email,
            password,
        }),
    });
    const data = await res.json();


    if (data.error) {
        setError(data.error);
        console.log(data.error);
    } else {
        //set token
        localStorage.setItem("token", data.token);
        //set user
        localStorage.setItem("nome", JSON.stringify(data.nome));
        //set user id
        localStorage.setItem("id", data.id);
        router.push("/chat");
    }


  


};

const handleEmailChange = (e) => {

    setEmail(e.target.value);
};

const handlePasswordChange = (e) => {
    setPassword(e.target.value);
};

  return (
    <div className="min-h-100%  min-w-100% flex items-center justify-center py-1 px-1 sm:px-2 lg:px-4">
      <Head>
        <title>QuarkChat</title>
        <meta name="description" content="Fale com seus amigos" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="/assets/logo Quark.svg" />
      </Head>
      <section className=" bg-gray-900">
        <div className="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-100%  lg:py-0">
          <a
            href="/"
            className="flex items-center mb-6 text-2xl font-semibold text-white"
          >
            <Image
              src="/assets/logo Quark.svg"
              width={50}
              height={50}
              alt="logo"
            />
            <span className="ml-2 text-xl font-bold tracking-wider uppercasetext-white">
              QuarkChat
            </span>
          </a>
          <div className="w-full rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 bg-gray-800border-gray-700">
            <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 className="text-xl font-bold leading-tight tracking-tight  md:text-2xl text-white">
                Entre Na Sua Conta
              </h1>
              <form className="space-y-4 md:space-y-6" action="#">
                <div>
                  <label
                    htmlFor="email"
                    className="block mb-2 text-sm font-medium  text-white"
                  >
                    Seu email
                  </label>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    onChange={handleEmailChange}
                    className=" sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="name@company.com"
                    required=""
                  />
                </div>
        

                <div>
                  <label
                    htmlFor="password"
                    className="block mb-2 text-sm font-medium text-white"
                  >
                    Password
                  </label>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    onChange={handlePasswordChange}
                    placeholder="••••••••"
                    className="sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    required=""
                  />
                </div>

                <button
                  onClick={handleSubmit}
                  type="submit"
                  className="w-full  text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800"
                >
                  Entrar na Conta
                </button>
                <p className="text-sm font-light text-gray-400">
                  Não tens uma conta?{" "}
                  <a
                    href="/register"
                    className="font-medium text-primary-600 hover:underline text-primary-500"
                  >
                    Crie aqui
                  </a>
                </p>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default login;
