export default {

    /** Auth **/
    async forgotPassword(email) {
        return window.axios.post('/api/forgot-password', {email})
    },
    async resetPassword(params) {
        return window.axios.post('/api/reset-password', params)
    },

    /** Update Password **/
    async updatePassword(params) {
        return window.axios.post('/api/users/update-password', params)
    }

}
