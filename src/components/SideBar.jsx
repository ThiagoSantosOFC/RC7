import React from "react";
import Image from "next/image";
import Link from "next/link";
import { useState, useEffect } from "react";

export const SideBar = () => {
  const [nav, setNav] = useState(false);
  const [id, setId] = useState("");
  const [email, setEmail] = useState("");
  const [nome, setNome] = useState("");
  const [token, setToken] = useState("");
  const [error, setError] = useState("");
  const [tag, setTag] = useState("");
  const [quarks, setQuarks] = useState([{}]);
  const [friends, setFriends] = useState([{}]);
  const [messages, setMessages] = useState([{}]);
  //amigo nome and amigoid and amigo email are an array


  const [amigoNome, setAmigoNome] = useState("");

  const [amigoTag, setAmigoTag] = useState("");

  useEffect(() => {
    const id = localStorage.getItem("id");
    const email = localStorage.getItem("email");
    const nome = localStorage.getItem("nome");
    const token = localStorage.getItem("token");
    const tag = localStorage.getItem("tag");
    setId(id);
    setEmail(email);
    setNome(nome);

    //remove "" from nome
    setNome(nome.replace(/['"]+/g, ""));
    setTag(tag);
    setToken(token);
  }, []);

  const handleNav = () => {
    setNav(!nav);
  };
  useEffect(() => {
    const Main = document.getElementById("Main");
    const open = document.getElementById("open");
    const close = document.getElementById("close");

    if (nav) {
      Main.classList.remove("translate-x-full");
      Main.classList.add("translate-x-0");
      open.classList.add("hidden");
      close.classList.remove("hidden");
    }
    if (!nav) {
      Main.classList.remove("translate-x-0");
      Main.classList.add("translate-x-full");
      open.classList.remove("hidden");
      close.classList.add("hidden");
    }
  }, [nav]);

  //when click iconAbrePerfil drop down menu
  const handleMenuPerfil = () => {
    const menuPerfil = document.getElementById("menuPerfil");
    menuPerfil.classList.toggle("hidden");

    const arrowPerfil = document.getElementById("iconAbrePerfil");
    arrowPerfil.classList.toggle("rotate-180");
  };

  const handleMenuQuarks = () => {
    const menuQuarks = document.getElementById("menuQuarks");
    //translates the arrow
    const arrowQuarks = document.getElementById("iconAbreQuarks");
    menuQuarks.classList.toggle("hidden");
  };

  //get user name from local storage

  function handleLogout() {
    localStorage.clear();
    window.location.href = "/";
  }

  //function to show dropdownUsers
  const showMessages = () => {
    const dropdownUsers = document.getElementById("dropdownUsers");
    dropdownUsers.classList.toggle("hidden");
  };

  const gotoJoinQuark = () => {
    window.location.href = "/joinquark";
  };

  //invite users menu popup
  const showInviteUsers = () => {
    const inviteUsers = document.getElementById("inviteUser");
    inviteUsers.classList.toggle("hidden");
  };

  function handleInviteUser() {
    console.log("invite user");
  }

  function gotoSettings() {
    window.location.href = "/settings";
  }

  function gotoCreateQuark() {
    window.location.href = "/createquark";
  }

  //get all user friends

  useEffect(() => {
    fetch("http://localhost/backend/user/get.php", {
      method: "GET",
    })
      .then((res) => res.json())
      .then((data) => {
        //if no friends
        if (!data) {
          return;
        } else {
          setFriends(data.user);
          
        }
      })
      .catch((err) => {
        setError(err);
      });
  }, []);

  //remove myself from friends list

  const removeMyself = friends.filter((friend) => {
    return friend.id !== id;
  });

  //run friends array and get friend name and id and email then put it into local storage


  const handleDm = (e) => {
    //get chat element by id then show it with friend info
    const chat = document.getElementById("chat");
    if (chat.classList.contains("hidden")) {
      chat.classList.remove("hidden");
      //get amigo data from innertext
      const amigo = e.target.innerText;
      //split amigo data into array
      const amigoData = amigo.split("#");
  
     
   setAmigoNome(amigoData[0]);
    setAmigoTag(amigoData[1]);

      //get friend name

    } else {
      setAmigoNome("");
      setAmigoTag("");
      
      chat.classList.add("hidden");
    }
  };


  const renderFriends = removeMyself.map(({ id, Nome, tag }) => {
    return (
      <div
        className="flex flex-col w-full h-full p-2 rounded-lg bg-gray-800 text-gray-200"
        onClick={handleDm}
        key={id}
        id="dados"
      >
        <div onClick={handleDm} className="flex flex-row justify-between items-center">
          
          <div onClick={handleDm} className="flex flex-row items-center">
            <img
            
              src={`https://api.dicebear.com/5.x/adventurer-neutral/svg?seed=${
                 Nome+tag 
              }`}
              alt="user"
              
              width={40}
              height={40}
              className="rounded-full"
            />
            <p  className="px-1 text-lg">{Nome + "#" + tag}</p>
          </div>
        </div>
      </div>
    );
  });

  // getAll quarks then render it
  useEffect(() => {
    //get token from local storage
    const token = localStorage.getItem("token");
    fetch(
      `http://localhost/backend/chat/menbers/getservers.php?token=${token}`,
      {
        method: "GET",
      }
    )
      .then((res) => res.json())
      .then((data) => {
        //if no quarks
        if (!data) {
          return null;
        } else {
          setQuarks(data.servers);
        }
      })
      .catch((err) => {
        setError(err);
      });
  }, []);

  //verify if user is in a quark

  function verificaQuarks() {
    if (!quarks) {
      return (
        <p className="flex flex-col w-full h-full p-2 rounded-lg bg-gray-800 text-gray-200">
          Não tens Quarks
        </p>
      );
    } else {
      quarks.map(({ idunique, name, id }) => {
        return (
          <div
            className="flex flex-col w-full h-full p-2 rounded-lg bg-gray-200 dark:bg-gray-800 dark:text-gray-200"
            key={idunique}
          >
            <div className="flex flex-row justify-between items-center">
              <p>{name} </p>
            </div>
          </div>
        );
      });
    }
  }

  const renderQuarks = verificaQuarks();

  function sendDm() {}

  return (
    <div className="flex flex-row min-h-full min-w-full  ">
      <div className="rounded-r  bg-gray-900 xl:hidden flex justify-between w-full p-6 items-center ">
        <div className="flex justify-between  items-center space-x-3">
          <Image
            src="/assets/logo Quark.svg"
            width={50}
            height={50}
            alt="logo"
          />

          <Link href="/">
            <p className="text-2xl leading-6 text-white">QuarkChat</p>
          </Link>
        </div>

        <div aria-label="toggler" className="flex justify-center items-center">
          <button
            aria-label="open"
            id="open"
            onClick={handleNav}
            className="hidden focus:outline-none focus:ring-2"
          >
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M4 6H20"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
              <path
                d="M4 12H20"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
              <path
                d="M4 18H20"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
            </svg>
          </button>
          <button
            aria-label="close"
            id="close"
            onClick={handleNav}
            className=" focus:outline-none focus:ring-2"
          >
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M18 6L6 18"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
              <path
                d="M6 6L18 18"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
            </svg>
          </button>
        </div>
      </div>
      <div
        id="Main"
        className="xl:rounded-r transform  xl:translate-x-0  ease-in-out transition duration-500 flex justify-start items-start min-h-full  min-w-75% sm:w-64 ring-2  bg-gray-900 flex-col"
      >
        <div className="hidden xl:flex justify-start p-6 items-center space-x-3">
          <Image
            src="/assets/logo Quark.svg"
            width={50}
            height={50}
            alt="logo"
          />

          <p className="text-2xl leading-6 text-white">QuarkChat</p>
        </div>

        <div className="flex flex-col justify-start items-center px-6 border-b border-gray-600 w-full  ">
          <button
            onClick={handleMenuPerfil}
            className="focus:outline-none focus:text-indigo-400 text-left  text-white flex justify-between items-center w-full py-5 space-x-14  "
          >
            <p className="text-sm leading-5  uppercase">Visão do perfil</p>
            <svg
              id="iconAbrePerfil"
              className="transform"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M18 15L12 9L6 15"
                stroke="currentColor"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
            </svg>
          </button>
          <div
            id="menuPerfil"
            className="flex justify-start  flex-col w-full md:w-auto items-start pb-1 "
          >
            <button
              onClick={showMessages}
              className="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52"
            >
              <svg
                className="fill-stroke"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M15 10L11 14L17 20L21 4L3 11L7 13L9 19L12 15"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
              <p className="text-base leading-4 ">Mensagens</p>
            </button>
            {/*
              aqui vai a lista de dms

            */}

            <div className="">
              <div
                id="dropdownUsers"
                className="z-10 hidden rounded shadow w-60 bg-gray-900"
              >
                <ul
                  id="dropdownUsersList"
                  className="h-48 py-1 overflow-y-auto  dark:text-gray-200"
                  aria-labelledby="dropdownUsersButton"
                >
                  <li>{renderFriends}</li>
                </ul>
                <a 
                  onClick={showInviteUsers}
                  className=" hidden items-center p-3 text-sm font-medium text-blue-600 border-t border-gray-200 bg-gray-50 dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-blue-500 hover:underline"
                >
                  <svg
                    className="w-5 h-5 mr-1"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                  </svg>
                  <span>Convidar um Amigo</span>
                </a>
                {/* pop up inviteUser */}
                <div
                  id="inviteUser"
                  className="hidden absolute top-82 left-80 right-70 w-full h-75%"
                >
                  <div className="flex justify-center items-center h-full">
                    <div className="bg-gray-900 rounded shadow-lg w-96">
                      <div className="border-b px-4 py-2 flex justify-between items-center">
                        <input
                          id="userAdd"
                          type="text"
                          placeholder="amigo#1234"
                          className="bg-gray-800 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                        />
                        <button
                          onClick={handleInviteUser}
                          className="text-gray-300 hover:text-gray-100 focus:outline-none focus:text-gray-100"
                        >
                          <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M21 12H12V21H10V12H1V10H10V1H12V10H21V12Z"
                              fill="currentColor"
                            />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <button
              onClick={gotoSettings}
              className="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2 w-full md:w-52"
            >
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M14 8.00002C15.1046 8.00002 16 7.10459 16 6.00002C16 4.89545 15.1046 4.00002 14 4.00002C12.8954 4.00002 12 4.89545 12 6.00002C12 7.10459 12.8954 8.00002 14 8.00002Z"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M4 6H12"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M16 6H20"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M8 14C9.10457 14 10 13.1046 10 12C10 10.8954 9.10457 10 8 10C6.89543 10 6 10.8954 6 12C6 13.1046 6.89543 14 8 14Z"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M4 12H6"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M10 12H20"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M17 20C18.1046 20 19 19.1046 19 18C19 16.8955 18.1046 16 17 16C15.8954 16 15 16.8955 15 18C15 19.1046 15.8954 20 17 20Z"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M4 18H15"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M19 18H20"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
              <p className="text-base leading-4  ">Definições</p>
            </button>
            <button className="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M10 6H7C6.46957 6 5.96086 6.21071 5.58579 6.58579C5.21071 6.96086 5 7.46957 5 8V17C5 17.5304 5.21071 18.0391 5.58579 18.4142C5.96086 18.7893 6.46957 19 7 19H16C16.5304 19 17.0391 18.7893 17.4142 18.4142C17.7893 18.0391 18 17.5304 18 17V14"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M17 10C18.6569 10 20 8.65685 20 7C20 5.34314 18.6569 4 17 4C15.3431 4 14 5.34314 14 7C14 8.65685 15.3431 10 17 10Z"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
              <p className="text-base leading-4  ">Notificações</p>
            </button>
          </div>
        </div>
        <div className="flex flex-col justify-start items-center   px-6 border-b border-gray-600 w-full  ">
          <div className="flex flex-col justify-between items-center h-full pb-2   px-6  w-full  space-y-2 ">
            <button
              onClick={handleMenuQuarks}
              className="focus:outline-none focus:text-indigo-400  text-white flex justify-between items-center w-full  space-x-14  "
            >
              <p className="text-sm leading-5  uppercase">Quarks</p>
              <svg
                id="iconAbreQuarks"
                className="rotate-180 transform"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M18 15L12 9L6 15"
                  stroke="currentColor"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
            </button>
            <div
              id="menuQuarks"
              className="flex flex-col justify-start items-start  w-75%"
            >
              <button
                onClick={gotoCreateQuark}
                className="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52"
              >
                <p className="text-sm leading-5  ">Criar Quark</p>
              </button>

              <button
                onClick={gotoJoinQuark}
                className="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52"
              >
                <p className="text-sm leading-5  ">Entrar num Quark</p>
              </button>
              <div className="flex flex-col justify-start items-start  w-75%">
                {quarks != 0 ? (
                  renderQuarks
                ) : (
                  //if not, show this
                  <div className="flex flex-col justify-start items-start  w-100%">
                    <p className="text-sm leading-5  ">Não tens quarks</p>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>

        <div className=" flex justify-start  flex-col w-full md:w-auto items-start pb-1 h-75% ">
          <div className="flex flex-row justify-start items-center space-y-2 px-2 w-full">
            <div className="flex justify-start items-start  space-x-2">
              <div>
                <img
                  className="rounded-full"
                  src={`https://api.dicebear.com/5.x/adventurer-neutral/svg?seed=${
                    id + email + nome
                  }`}
                  alt="avatar"
                  width={40}
                  height={40}
                />
              </div>
              <div className="flex justify-start flex-col items-start">
                <p className="cursor-pointer text-sm leading-5 text-white">
                  {nome + "#" + tag}
                </p>
                <p className="cursor-pointer text-xs leading-3 text-gray-300">
                  {email}
                </p>
              </div>
            </div>
            <svg
              onClick={gotoSettings}
              className="cursor-pointer"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M10.325 4.317C10.751 2.561 13.249 2.561 13.675 4.317C13.7389 4.5808 13.8642 4.82578 14.0407 5.032C14.2172 5.23822 14.4399 5.39985 14.6907 5.50375C14.9414 5.60764 15.2132 5.65085 15.4838 5.62987C15.7544 5.60889 16.0162 5.5243 16.248 5.383C17.791 4.443 19.558 6.209 18.618 7.753C18.4769 7.98466 18.3924 8.24634 18.3715 8.51677C18.3506 8.78721 18.3938 9.05877 18.4975 9.30938C18.6013 9.55999 18.7627 9.78258 18.9687 9.95905C19.1747 10.1355 19.4194 10.2609 19.683 10.325C21.439 10.751 21.439 13.249 19.683 13.675C19.4192 13.7389 19.1742 13.8642 18.968 14.0407C18.7618 14.2172 18.6001 14.4399 18.4963 14.6907C18.3924 14.9414 18.3491 15.2132 18.3701 15.4838C18.3911 15.7544 18.4757 16.0162 18.617 16.248C19.557 17.791 17.791 19.558 16.247 18.618C16.0153 18.4769 15.7537 18.3924 15.4832 18.3715C15.2128 18.3506 14.9412 18.3938 14.6906 18.4975C14.44 18.6013 14.2174 18.7627 14.0409 18.9687C13.8645 19.1747 13.7391 19.4194 13.675 19.683C13.249 21.439 10.751 21.439 10.325 19.683C10.2611 19.4192 10.1358 19.1742 9.95929 18.968C9.7828 18.7618 9.56011 18.6001 9.30935 18.4963C9.05859 18.3924 8.78683 18.3491 8.51621 18.3701C8.24559 18.3911 7.98375 18.4757 7.752 18.617C6.209 19.557 4.442 17.791 5.382 16.247C5.5231 16.0153 5.60755 15.7537 5.62848 15.4832C5.64942 15.2128 5.60624 14.9412 5.50247 14.6906C5.3987 14.44 5.23726 14.2174 5.03127 14.0409C4.82529 13.8645 4.58056 13.7391 4.317 13.675C2.561 13.249 2.561 10.751 4.317 10.325C4.5808 10.2611 4.82578 10.1358 5.032 9.95929C5.23822 9.7828 5.39985 9.56011 5.50375 9.30935C5.60764 9.05859 5.65085 8.78683 5.62987 8.51621C5.60889 8.24559 5.5243 7.98375 5.383 7.752C4.443 6.209 6.209 4.442 7.753 5.382C8.753 5.99 10.049 5.452 10.325 4.317Z"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
              <path
                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                stroke="white"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
              />
            </svg>
          </div>

          <div className="flex flex-col justify-start items-start space-y-2 px-2 mt-2 w-full">
            <button onClick={handleLogout} className="cursor-pointer">
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M17 12H8"
                  stroke="white"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M12 17L8 12L12 7"
                  stroke="white"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
                <path
                  d="M2 12H22"
                  stroke="white"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
              <p className="text-xs text-white">Logout</p>
            </button>
          </div>
        </div>
      </div>

      <div id="chat" className=" flex-auto hidden text-gray-200 space-x-1">
        <div className="flex-1 p:2 sm:p-6 justify-between flex flex-col w-85% h-screen">
          <div className="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
            <div className="relative flex items-center space-x-4">
              <div className="relative">
                <span className="absolute text-green-500 right-0 bottom-0">
                  <svg width="20" height="20">
                    <circle cx="8" cy="8" r="8" fill="currentColor"></circle>
                  </svg>
                </span>
                <img
                  src={`https://api.dicebear.com/5.x/adventurer-neutral/svg?seed=${
                     amigoNome + amigoTag 
                  }`}
                  alt="/"
                  className="w-10 sm:w-16 h-10 sm:h-16 rounded-full"
                />
              </div>
              <div className="flex flex-col leading-tight">
                <div className="text-2xl mt-1 flex items-center">
                  <span className="text-gray-200 mr-3"> {amigoNome +"#"+amigoTag}</span>
                </div>
                <span className="text-lg text-gray-600"></span>
              </div>
            </div>
            <div className="flex items-center space-x-2">
              <button
                type="button"
                className="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  className="h-6 w-6"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  ></path>
                </svg>
              </button>
              <button
                type="button"
                className="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  className="h-6 w-6"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                  ></path>
                </svg>
              </button>
              <button
                type="button"
                className="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  className="h-6 w-6"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
          <div
            id="messages"
            className="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch"
          ></div>
          <div className="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
            <div className="relative flex">
              <span className="absolute inset-y-0 flex items-center"></span>
              <input
                type="text"
                placeholder="Escreva sua mensagem..."
                className="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-md py-3"
              />
              <div className="absolute right-0 items-center inset-y-0 hidden sm:flex">
                <button
                  type="button"
                  className="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none"
                >
                  <span className="font-bold">Enviar</span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    className="h-6 w-6 ml-2 transform rotate-90"
                  >
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
