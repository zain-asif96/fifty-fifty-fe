<script setup>


const navItems = [
    {
        title: 'privacy',
        label: 'Privacy Policy',
        url: '/privacy',
    },
    {
        title: 'terms',
        label: 'Terms and Conditions of Use',
        url: '/terms',
    },
];

const socialLinks = [
    {
        title: 'facebook',
        icon: 'images/icons/social/facebook.svg',
        url: 'https://facebook.com'
    },
    {
        title: 'twitter',
        icon: 'images/icons/social/twitter.svg',
        url: 'https://twitter.com'
    },
    {
        title: 'instagram',
        icon: 'images/icons/social/instagram.svg',
        url: 'https://instagram.com'
    }
];

</script>

<template>
    <footer class="fifty-footer">
        <div class="inside-container">
            <div class="main">
                <img alt="Fifty Fifty Logo" src="images/icons/logo/fifty_fifty_logo.svg" class="logo-img">

                <div class="footer-nav-items">
                    <div v-for="item in navItems" :key="item.title" class="nav-item">
                        <a :href="item.url">{{ item.label }}</a>
                    </div>
                </div>
            </div>

            <div class="secondary">
                <div class="social-links">
                    <a v-for="link in socialLinks" :key="link.title" :href="link.url" class="link">
                        <img :alt="link.title" :src="link.icon">
                    </a>
                </div>

                <div class="rights-text">
                    FiftyFifty© 1996-2023. All rights reserved—a Quad Industrial Solutions Product.
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer"
}
</script>
