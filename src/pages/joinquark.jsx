import React from "react";
import Image from "next/image";
import Head from "next/head";
import { useState, useEffect} from "react";
import { useRouter } from "next/router";

const joinquark = () => {


const router = useRouter();
const [name, setname] = useState("");
const [owner_token, setToken] = useState("");

useEffect(() => {
    const owner_token = localStorage.getItem("token");
    const name = localStorage.getItem("nome");
   
    if (!owner_token) {
      router.push("/login");
    }
  
    setname(name);
    setToken(owner_token);
    console.log(owner_token);
    console.log(name);
 
  }, []);
  



const handleSubmit = async (e) => {
    e.preventDefault();
    if (name == "") {
        alert("Dê um nome para o Quark");
        return;
    }


    try {
        fetch("http://localhost/backend/chat/create.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            }
            ,
            body: JSON.stringify({
                name,
                owner_token
            }),
        }).then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.error) {
                    setError(data.error);
                    console.log(data.error);
                } else {
                    router.push("/chat");
                }
            });
        
    }
    catch (error) {
        console.log(error);
    }
    


};


const handleNomeChange = (e) => {
    setname(e.target.value);
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
               
                <div className="space-y-1">

                  <label
                    htmlFor="nome"
                    className="block mb-2 text-sm font-medium  text-white"
                  >
                  id do quark
                  </label>
                  <input
                    type="text"
                    name="nome"
                    id="nome"
                    onChange={handleNomeChange}
                    className=" sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Meu Quark"
                    required
                  />
                </div>


 
                <button
                  onClick={handleSubmit}
                  type="submit"
                  className="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700"
                >
                  Entrar no Quark
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

export default joinquark;
