// axios
import axios from 'axios'

const baseURL = process.env.MIX_APP_VUE_BASE_PATH

export default axios.create({
  baseURL
  // You can add your headers here
})
