import React from "react";
import Image from "next/image";
import Head from "next/head";
import { useState } from "react";
import { useRouter } from "next/router";
import { useEffect } from "react";

const register = () => {
const [email, setEmail] = useState("");
const [password, setPassword] = useState("");
const [password2, setPassword2] = useState("");
const [nome, setnome] = useState("");
const [error, setError] = useState("");

const router = useRouter();
useEffect(() => {
    if (!localStorage.getItem("token")) {
      router.push("/login");
    }
  }, []);
  

const handleSubmit = async (e) => {
    e.preventDefault();
    if (password !== password2) {
        setError("Senhas não são iguais");
        return;
    }
   //fetch with cors headers

    const res = await fetch("http://localhost/backend/user/create.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            email,
            password,
            nome,
        }),
    });
    const data = await res.json();
    if (data.error) {
        setError(data.error);
        console.log(data.error);
    } else {
        router.push("/login");
    }


};

const handleEmailChange = (e) => {

    setEmail(e.target.value);
};

const handlePasswordChange = (e) => {
    setPassword(e.target.value);
};

const handlePassword2Change = (e) => {
    setPassword2(e.target.value);
};

const handleNomeChange = (e) => {
    setnome(e.target.value);
};

const handleTagChange = (e) => {
    setTag(e.target.value);
};






  return (
    <div className="h-full  w-full flex items-center justify-center py-1 px-1 sm:px-2 lg:px-4">
      <Head>
        <title>QuarkChat</title>
        <meta name="description" content="Fale com seus amigos" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="/assets/logo Quark.svg" />
      </Head>
      <section className=" bg-gray-900">
        <div className="flex flex-col items-center justify-center px-2 py-4  w-full md:h-100%  lg:py-0">
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
          <div className="w-full h-full rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 bg-gray-900 border-gray-700">
            <div className="p-2 space-y-4 md:space-y-6 sm:p-8">
              <h1 className="text-xl font-bold leading-tight tracking-tight  md:text-2xl text-white">
                Atualize suas informações
              </h1>
              <form className="space-y-2 md:space-y-2 w-full" action="#">
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
                    htmlFor="nome"
                    className="block mb-2 text-sm font-medium  text-white"
                  >
                    Seu nome
                  </label>
                  <input
                    type="text"
                    name="nome"
                    id="nome"
                    onChange={handleNomeChange}
                    className=" sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="John Doe"
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
                <div>
                  <label
                    htmlFor="confirm-password"
                    className="block mb-2 text-sm font-medium  text-white"
                  >
                    Confirme sua password
                  </label>
                  <input
                    type="password"
                    name="confirm-password"
                    id="confirm-password"
                    onChange={handlePassword2Change}
                    placeholder="••••••••"
                    className=" sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    required=""
                  />
                </div>
                <div className="flex items-start">
                 
                  <div className="ml-3 text-sm">
                   
                  </div>
                </div>
                <button
                  onClick={handleSubmit}
                  type="submit"
                  className="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700"
                >
                  Atualizar
                </button>
                
                <a
                    href="/chat"
                    className="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700"
                    >
                    Voltar
                </a>

               
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default register;
