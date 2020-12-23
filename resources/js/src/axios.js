// axios
import axios from 'axios'

const baseURL = process.env.MIX_APP_VUE_PUBLIC_PATH

export default axios.create({
  baseURL
  // You can add your headers here
})
