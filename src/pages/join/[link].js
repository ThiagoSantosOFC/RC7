import React from 'react'
import Head from "next/head";
import { useRouter } from "next/router";
import { useEffect } from "react";


// Get static props
export async function getStaticProps(context) {
  const link = context.params.link;
  return {
    props: {
      link: link
    }
  }
}

// Get static paths
export async function getStaticPaths() {
  return {
    paths: [],
    fallback: true
  }
}


// Join page
const Join = ({ link }) => {
  const router = useRouter();
  
    /*
      Do post request to:
      http://localhost/backend/chat/invite/join.php
      with body:
      {
        "link": "link",
        "token": "token"
      }
    */
    
  // Verify if user has token if not redirect to login page
  useEffect(() => {
    // Get token from local storage
    const token = localStorage.getItem("token");
    if (!token) {
      // Redirect to login
      router.push("/login");
    }
  }, []);


  useEffect(() => {
    // Get link from url
    if (link) {
      // Get token from local storage
      const token = localStorage.getItem("token");
      console.log(token);
      if (token) {
        // Send post request to join chat
        fetch("http://localhost/backend/chat/invite/join.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            link: link,
            token: token
          })
        })
          .then(res => res.json())
          .then(data => {
            // Redirect to chat
            router.push("/chat");
          }
        );
      } else {
        // Redirect to login
        router.push("/login");
      }
    }
  }, [link]);

  return (
    <>
      <Head>
        <title>Join</title>
      </Head>
      <div className="container">
        <h1>{link}</h1>
      </div>
    </>
  )
}

export default Join