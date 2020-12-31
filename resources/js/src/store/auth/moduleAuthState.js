/*=========================================================================================
  File Name: moduleAuthState.js
  Description: Auth Module State
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  isAuthenticated: () => {
    let isAuthenticated = false

    if (localStorage.getItem('userInfo')) isAuthenticated = true
    else isAuthenticated = false

    return isAuthenticated
  }
}
