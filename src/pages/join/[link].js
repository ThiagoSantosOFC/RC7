import { useRouter } from 'next/router'
import { useEffect } from 'react'

const Post = () => {
  const router = useRouter();
  const { link } = router.query;

  /*
  ENDPOINT: http://localhost/backend/chat/invite/join.php

  JSON: 
  {
    "link": "link",
    "token": "token"
  }
  */

  return (
    <div>
      <h1>Joining {link}</h1>
    </div>
  )
}

export default Post