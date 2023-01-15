import { useRouter } from 'next/router'

const Post = () => {
  const router = useRouter()
  const { link } = router.query

  return <p>Post: {link}</p>
}

export default Post