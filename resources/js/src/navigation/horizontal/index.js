export default [{
        header: 'Dashboard',
        icon: 'HomeIcon',

        children: [{
                title: 'Analytics',
                route: 'dashboard-analytics',
                icon: 'ActivityIcon',
            },


        ],
    },
    {
        header: 'My Account',
        icon: 'SettingsIcon',

        children: [{
                title: 'Update Password',
                route: 'update-password',
                icon: 'LockIcon',
            },
            // {
            //     title: 'Update Email Address',
            //     route: 'update-email-address',
            //     icon: 'MailIcon',
            // },
            {
                title: 'Update Profile',
                route: 'update-profile',
                icon: 'UserIcon',
            },
            // {
            //     title: 'Apps',
            //     route: 'apps',
            //     icon: 'PackageIcon',
            // },
            // {
            //     title: 'Logs',
            //     route: 'logs',
            //     icon: 'AlertCircleIcon',
            // },
        ],
    },



    // for Company

    {
        header: 'Manage Users',
        icon: 'UserIcon',
        gate: 'manage_users_access',
        children: [{
            title: 'All Users',
            route: 'manage-user',
            icon: 'UserIcon',
        }, ]
    },
    {
        header: 'Manage Products',
        icon: 'UserIcon',
        gate: 'manage_products_access',
        children: [{
            title: 'All Products',
            route: 'manage-products',
            icon: 'UserIcon',
        }, ]
    },
    {
        header: 'Manage Orders',
        icon: 'UserIcon',
        gate: 'manage_orders_access',
        children: [{
            title: 'All Orders',
            route: 'manage-orders',
            icon: 'UserIcon',
        }, ]
    },

    // for supplier
    {
        header: 'Orders',
        icon: 'UserIcon',
        gate: 'orders_access',

        children: [{

            title: 'View Orders',
            route: 'orders',
            icon: 'UserIcon',
        }, ]
    },
    // for customer
    {
        header: 'My Orders',
        icon: 'UserIcon',
        gate: 'my_orders_access',
        children: [{

                title: 'View Orders',
                route: 'orders',
                icon: 'UserIcon',
            },

        ]
    },

    // {
    //     header: 'Contact Us',
    //     icon: 'MailIcon',
    //     children: [{
    //         title: 'Contact Now',
    //         route: 'contact-us',
    //         icon: 'MailIcon',
    //     }, ]
    // },
]