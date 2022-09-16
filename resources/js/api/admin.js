const admin = {
    getPermissions(cb, errorCB, userLevel) {
        axios
            .get(window.API_URL + `admin/getPermissions/${userLevel}`)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getAdminInfo(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getAdminInfo')
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getUsers(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getUsers')
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getUserDetail(id, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/getUserDetail/${id}`)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getGroupDetail(data, cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getGroupDetail?id=' + data.id)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    UpdateUserInfo(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/UpdateUserInfo', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    createUser(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/createUser', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    createGroup(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/createGroup', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateGroup(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateGroup', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateAdminInfo(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateAdminInfo', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

    updatePassword(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updatePassword', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateEmail(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateEmail', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getAppLinks(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getAppLinks')
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getUserLogs(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getUserLogs')
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

    getGroups(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getGroups')
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

    logout(cb, errorCB) {
        axios
            .post(window.API_URL + 'logout')
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

    deleteRecords(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/deleteRecords', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    deleteUser(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/deleteUser', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    // getMFADetail(cb, errorCB, user_id) {
    //     axios
    //         .get(window.API_URL + `admin/getMFADetail/${user_id}`)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // UpdateMFA(data, cb, errorCB) {
    //     axios
    //         .post(window.API_URL + `admin/UpdateMFA`, data)
    //         .then(resp => {

    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // getUserGroups(user_id, cb, errorCB) {
    //     axios
    //         .get(window.API_URL + `admin/getUserGroups/${user_id}`)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // AddToGroup(user_id, data, cb, errorCB) {
    //     axios
    //         .post(window.API_URL + `admin/AddToGroup/${user_id}`, data)
    //         .then(resp => {

    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // getGroupMembers(group_id, cb, errorCB) {
    //     axios
    //         .get(window.API_URL + `admin/getGroupMembers/${group_id}`)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // DeleteMember(group_id, data, cb, errorCB) {
    //     axios
    //         .post(window.API_URL + `admin/DeleteMember/${group_id}`, data)
    //         .then(resp => {

    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // addBulkUser(data, cb, errorCB) {
    //     axios
    //         .post(window.API_URL + `admin/addBulkUser`, data)
    //         .then(resp => {

    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // for this project
    getRelUsers(cb, errorCB, userLevel) {
        axios
            .get(window.API_URL + `admin/getRelUsers/${userLevel}`)
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    saveOrder(data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/saveOrder`, data)
            .then(resp => {
                console.log('the save order response is', resp);
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB('err.response.data');
            })
    },
    getOrders(userId, userLevel, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/getOrders/${userId}/${userLevel}`)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getWarehouseDetail(userId, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/getWarehouseDetail/${userId}`)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    addWarehouseDetail(data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/addWarehouseDetail`, data)
            .then(resp => {
                console.log('the save order response is', resp);
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB('err.response.data');
            })
    },
    addProductType(data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/addProductType`, data)
            .then(resp => {
                console.log('the save order response is', resp);
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB('err.response.data');
            })
    },
    addProduct(data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/addProduct`, data)
            .then(resp => {
                console.log('the addProduct response is', resp);
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB('err.response.data');
            })
    },




    getSingleProduct(productId, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/getSingleProduct/${productId}`)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateProfileInfo(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateProfileInfo', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateProduct(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateProduct', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getSingleOrder(orderId, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/getSingleOrder/${orderId}`)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    UpdateWarehouse(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/UpdateWarehouse', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },


    getData(url, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/${url}`)
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

    getRow(url, id, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/${url}/${id}`)
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

}

export default admin