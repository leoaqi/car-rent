<template>
    <div class="bg-white px-8 py-10">
        <div class="flex flex-row">
            <div class="w-[280px]">
                <img :src="logoaqi" alt="logo footer" class="w-40 h-20 object-contain">
                <h1 class="font-poppins text-sm text-text-secondary">
                    Our vision is to provide convenience and help increase your sales business.
                </h1>
            </div>
            <div class="ml-auto flex flex-row gap-20">
                <div>
                    <h1 class="text-xl text-text-primary font-poppins">About</h1>
                    <ul class="list-none space-y-2.5 mt-3">
                        <li>
                            <a href="#" class="footer-li">How it works</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Featured</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Partnership</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Business Relation</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h1 class="text-xl text-text-primary font-poppins">Community</h1>
                    <ul class="list-none space-y-2.5 mt-3">
                        <li>
                            <a href="#" class="footer-li">Events</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Blog</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Podcast</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Invite a friend</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h1 class="text-xl text-text-primary font-poppins">Social</h1>
                    <ul class="list-none space-y-2.5 mt-3">
                        <li>
                            <a href="#" class="footer-li">Facebook</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Instagram</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Tiktok</a>
                        </li>
                        <li>
                            <a href="#" class="footer-li">Youtube</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="w-full h-[1px] bg-natural-200 my-6"></div>
            <div class="flex flex-row justify-between items-center">
                <div class="flex flex-row items-center gap-1">
                    <i class="ri-copyright-line text-text-primary"></i>
                    <p class="text-text-primary text-sm font-poppins">2025 Car Rental. All rights reserved</p>
                </div>
                <div class="flex flex-row gap-8">
                    <a href="#" class="text-text-primary text-sm font-poppins hover:text-primary">Privacy &
                        Policy</a>
                    <a href="#" class="text-text-primary text-sm font-poppins hover:text-primary">Terms &
                        Condition</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import logoaqi from '../../../../../public/images/logoaqi.png'
</script>