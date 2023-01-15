import Head from 'next/head'

import { Inter } from '@next/font/google'

import { SideBar } from '../components/SideBar'

const inter = Inter({ subsets: ['latin'] })

export default function Home() {
  return (
    <>
      <Head>
        <title>QuarkChat</title>
        <meta name="description" content="Fale com seus amigos" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="/assets/logo Quark.svg" />
      </Head>
    
     <SideBar />

   
    </>
  )
}
