import React from 'react'
import { SideBar } from "../components/SideBar";
import Head from "next/head";
const chat = () => {
  return (
<div>
<Head>
        <title>QuarkChat</title>
        <meta name="description" content="Fale com seus amigos" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="/assets/logo Quark.svg" />
      </Head>
    <SideBar />

</div>
  )
}


export default chat