import React from 'react'
import Head from "next/head";
import { useRouter } from "next/router";
import { useEffect } from "react";

const Join = () => {
  const router = useRouter();
  //if user is not logged in, redirect to login page
  const { link } = router.query
 
  useEffect(() => {
    if (!localStorage.getItem("token")) {
      router.push("/login");
    }
    else{
      /*
      Do post request to:
      http://localhost/backend/chat/invite/join.php
      with body:
      {
        "link": "link",
        "token": "token"
      }
      */
      const token = localStorage.getItem("token");
      const data = {
        link: link ? link : "",
        token: token ? token : ""
      }
      const dataJson = JSON.stringify(data);

      try {
        fetch("http://localhost/backend/chat/invite/join.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: dataJson,
      })
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          if (data.status === "success") {
            router.push("/chat");
          } else {
            router.push("/error");
          }
        })
      }
      catch (err) {
        console.log(err);
      }
    }
  }, []);
  

  return (
<div>
      <Head>
        <title>QuarkChat</title>
        <meta name="description" content="Fale com seus amigos" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="/assets/logo Quark.svg" />
      </Head>
</div>
  )
}


export default Join