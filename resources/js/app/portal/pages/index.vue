<template>

    <!-- movie content -->
    <div class="w-full h-screen bg-blue-950 p-3 sm:p-10">
        <div class="w-full h-full bg-white p-5 sm:p-10 rounded-2xl drop-shadow-xl">

            <!-- movie content header part -->
            <div class="block sm:flex justify-between items-center mb-5">

                <!-- search part -->
                <div class="w-full sm:max-w-[450px] mb-3 sm:mb-0">
                    <div class="relative">
                        <input type="text" name="keyword" class="w-full py-3 ps-12 pe-5 rounded-xl outline-0 border border-gray-400" placeholder="Search here" v-model="keyword" required autocomplete="off" @input="searchData()" />
                        <div class="absolute top-0 bottom-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg viewBox="0 0 24 24" class="size-[25px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path class="stroke-black" d="M11 6C13.7614 6 16 8.23858 16 11M16.6588 16.6549L21 21M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- open modal button part -->
                <div class="flex justify-end items-center ms-3">
                    <button type="button" class="bg-blue-700 duration-500 hover:bg-blue-950 py-3 px-5 min-w-[110px] inline-flex justify-center items-center outline-0 border-0 text-white rounded-xl" @click="openManageModal(null)">
                        <span class="me-1"> New </span>
                        <svg viewBox="0 0 24 24" class="size-[20px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path class="stroke-white" d="M6 12H18M12 6V18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- movie content body part -->
            <div class="w-full bg-gray-200 overflow-y-auto rounded-xl" :class="{ 'h-[calc(100vh-280px)] p-5' : paginatedMovies.length > 0 && !loading, 'h-[calc(100vh-230px)]' : paginatedMovies.length === 0 && !loading, 'h-[calc(100vh-225px)]' : loading }">

                <!-- loading part -->
                <template v-if="loading">
                    <div class="flex justify-center items-center w-full h-full">
                        <svg viewBox="0 0 50 50" class="fill-blue-950 size-24 animate-spin" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M41.9 23.9c-.3-6.1-4-11.8-9.5-14.4-6-2.7-13.3-1.6-18.3 2.6-4.8 4-7 10.5-5.6 16.6 1.3 6 6 10.9 11.9 12.5 7.1 2 13.6-1.4 17.6-7.2-3.6 4.8-9.1 8-15.2 6.9-6.1-1.1-11.1-5.7-12.5-11.7-1.5-6.4 1.5-13.1 7.2-16.4 5.9-3.4 14.2-2.1 18.1 3.7 1 1.4 1.7 3.1 2 4.8.3 1.4.2 2.9.4 4.3.2 1.3 1.3 3 2.8 2.1 1.3-.8 1.2-2.5 1.1-3.8 0-.4.1.7 0 0z"></path>
                            </g>
                        </svg>
                    </div>
                </template>

                <!-- empty screen part -->
                <template v-if="paginatedMovies.length === 0 && !loading">
                    <div class="flex justify-center items-center w-full h-full flex-col">
                        <div class="mb-3">
                            <img :src="'/empty-screen.png'" alt="empty-screen" />
                        </div>
                        <div class="text-[18px] mb-3 font-semibold">
                            No Data Founded
                        </div>
                        <div class="text-center text-[15px]">
                            Click to "New" for add new data
                        </div>
                    </div>
                </template>

                <!-- list data part -->
                <template v-if="paginatedMovies.length > 0 && !loading">
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:gird-cols-3 2xl:grid-cols-4 gap-5">
                        <template v-for="(each, index) in paginatedMovies" :key="index">
                            <div class="rounded-xl shadow-xl p-5 bg-white">
                                <div class="flex justify-between items-center font-medium mb-3">
                                    <div class="block text-[13px]"> {{each.director}} </div>
                                    <div class="block text-[13px]"> {{each.release_year}} </div>
                                </div>
                                <div class="mb-3 text-[15px] font-medium block"> {{each.genre}} </div>
                                <div class="mb-3 text-[18px] font-medium block"> {{each.title}} </div>
                                <div class="block text-[13px] text-gray-800"> {{each.description}} </div>
                                <div class="flex justify-between items-center mt-4 gap-3">
                                    <button type="button" class="bg-gray-200 text-blue-950 duration-500 hover:bg-blue-950 hover:text-white w-full min-h-[50px] inline-flex justify-center items-center rounded-xl" @click="openManageModal(each.id)">
                                        Edit
                                    </button>
                                    <button type="button" class="bg-rose-200 text-rose-950 duration-500 hover:bg-rose-950 hover:text-white w-full min-h-[50px] inline-flex justify-center items-center rounded-xl" @click="openDeleteModal(each.id)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

            </div>

            <!-- movie content footer part -->
            <!-- pagination part -->
            <div class="mt-7 flex justify-center items-center rounded-md gap-x-2" v-if="paginatedMovies.length > 0 && !loading">
                <!-- Previous Button -->
                <button type="button" class="size-[25px] sm:size-[35px] outline-0 flex justify-center items-center rounded-md bg-transparent duration-500 hover:bg-gray-400 group" @click="previousPage" :disabled="currentPage === 1" aria-label="Close" aria-labelledby="close-button-label">
                    <svg viewBox="0 0 24 24" class="size-[25px] sm:size-[45px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 15L10 12L13 9" class="duration-500 stroke-black group-hover:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                <!-- Page Numbers -->
                <button v-for="page in visiblePages" :key="page" @click="changePage(page)" class="size-[25px] sm:size-[35px] outline-0 text-[11px] sm:text-[13px] font-semibold rounded-md duration-500 hover:bg-gray-400 focus:bg-emerald-800 focus:text-white" :class="{ 'bg-emerald-800 text-white': page === currentPage, 'bg-transparent text-black': !page === currentPage }" aria-label="Close" aria-labelledby="close-button-label">
                    {{ page }}
                </button>
                <!-- Next Button -->
                <button type="button" class="size-[25px] sm:size-[35px] outline-0 flex justify-center items-center rounded-md bg-transparent duration-500 hover:bg-gray-400 group" @click="nextPage" :disabled="currentPage === totalPages" aria-label="Close" aria-labelledby="close-button-label">
                    <svg viewBox="0 0 24 24" class="size-[25px] sm:size-[45px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 9L14 12L11 15" class="duration-500 stroke-black group-hover:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- manage modal -->
    <div class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 overflow-y-auto scrollbar p-5 md:p-16" :class="{ 'invisible bg-black/35' : !manageModal, 'visible bg-black/65' : manageModal }" @click="manageModal = false">
        <form @submit.prevent="manageApi" class="bg-white rounded-2xl min-w-full sm:min-w-[550px] p-5 sm:p-10 duration-500 origin-top" :class="{ '-translate-y-1/2 opacity-0' : !manageModal, 'translate-y-0 opacity-100' : manageModal }" @click.stop>

            <!-- manage modal header part -->
            <div class="flex justify-between items-center mb-4">
                <div class="text-[18px] md:text-[25px] font-medium">
                    <span v-if="this.formData.id === undefined"> Create </span>
                    <span v-if="this.formData.id !== undefined"> Edit </span> Movie
                </div>
                <button type="button" class="size-[35px] min-w-[35px] min-h-[35px] inline-flex justify-center items-center" @click="closeManageModal()">
                    <svg viewBox="0 0 24 24" class="size-[25px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                </button>
            </div>

            <!-- manage modal body -->
            <div class="w-full mb-4">
                <div class="mb-3 w-full">
                    <label for="title" class="block mb-1 text-[14px] sm:text-[18px] font-medium"> Title </label>
                    <input type="text" name="title" id="title" class="w-full h-[50px] outline-0 border-0 bg-gray-200 rounded-xl px-5" autocomplete="off" v-model="formData.title" />
                    <div class="mt-2 text-rose-500 text-[14px]" v-if="error.title"> {{error.title[0]}} </div>
                </div>
                <div class="mb-3 w-full">
                    <label for="description" class="block mb-1 text-[14px] sm:text-[18px] font-medium"> Description </label>
                    <textarea name="description" id="description" class="w-full h-auto outline-0 border-0 bg-gray-200 rounded-xl px-5 py-3" cols="30" rows="3" autocomplete="off" v-model="formData.description"></textarea>
                    <div class="mt-2 text-rose-500 text-[14px]" v-if="error.description"> {{error.description[0]}} </div>
                </div>
                <div class="mb-3 w-full">
                    <label for="release_year" class="block mb-1 text-[14px] sm:text-[18px] font-medium"> Release Year </label>
                    <input type="text" name="release_year" id="release_year" class="w-full h-[50px] outline-0 border-0 bg-gray-200 rounded-xl px-5" autocomplete="off" v-model="formData.release_year" />
                    <div class="mt-2 text-rose-500 text-[14px]" v-if="error.release_year"> {{error.release_year[0]}} </div>
                </div>
                <div class="mb-3 w-full">
                    <label for="director" class="block mb-1 text-[14px] sm:text-[18px] font-medium"> Director </label>
                    <input type="text" name="director" id="director" class="w-full h-[50px] outline-0 border-0 bg-gray-200 rounded-xl px-5" autocomplete="off" v-model="formData.director" />
                    <div class="mt-2 text-rose-500 text-[14px]" v-if="error.director"> {{error.director[0]}} </div>
                </div>
                <div class="mb-3 w-full">
                    <label for="genre" class="block mb-1 text-[14px] sm:text-[18px] font-medium"> Genre </label>
                    <div class="relative w-full">
                        <select name="genre" id="genre" class="w-full h-[50px] outline-0 border-0 bg-gray-200 rounded-xl px-5 appearance-none" autocomplete="off" v-model="formData.genre">
                            <option v-if="genres.length > 0" :value="''"> Select Genre </option>
                            <option v-if="genres.length > 0" v-for="(each,index) in genres" :value="each"> {{each}} </option>
                            <option v-if="genres.length === 0"> No Data Founded </option>
                        </select>
                        <div class="absolute top-0 bottom-0 end-0 flex justify-center items-center pe-5 pointer-events-none">
                            <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-rose-500 text-[14px]" v-if="error.genre"> {{error.genre[0]}} </div>
                </div>
                <div class="w-full">
                    <label for="rating" class="block mb-1 text-[14px] sm:text-[18px] font-medium"> Rating </label>
                    <div class="inline-flex justify-start items-center w-full">
                    <span v-for="star in 5" :key="star" @click="setRating(star)" class="text-[30px] cursor-pointer transition-colors duration-300" :class="{ 'text-yellow-400': star <= rating, 'text-gray-400': star > rating }">
                        ★
                    </span>
                    </div>
                    <div class="text-rose-500 text-[14px]" v-if="error.rating"> {{error.rating[0]}} </div>
                </div>
            </div>

            <!-- manage modal footer part -->
            <div class="flex justify-end items-center gap-2">
                <button type="button" class="min-w-[100px] sm:min-w-[120px] min-h-[45px] sm:min-h-[50px] text-[14px] font-medium sm:text-[16px] inline-flex justify-center items-center bg-gray-200 text-gray-950 duration-500 hover:bg-gray-600 hover:text-white rounded-xl" @click="closeManageModal()">
                    Cancel
                </button>
                <button type="submit" class="min-w-[100px] sm:min-w-[120px] min-h-[45px] sm:min-h-[50px] text-[14px] font-medium sm:text-[16px] inline-flex justify-center items-center bg-blue-200 text-blue-950 duration-500 hover:bg-blue-950 hover:text-white rounded-xl" v-if="!manageLoading">
                    <span v-if="this.formData.id === undefined"> Create </span>
                    <span v-if="this.formData.id !== undefined"> Update </span>
                </button>
                <button type="button" class="min-w-[100px] sm:min-w-[120px] min-h-[45px] sm:min-h-[50px] text-[14px] font-medium sm:text-[16px] inline-flex justify-center items-center bg-blue-200 text-blue-950 duration-500 hover:bg-blue-950 hover:text-white rounded-xl group" v-if="manageLoading">
                    <svg viewBox="0 0 50 50" class="fill-blue-950 duration-500 group-hover:fill-white size-8 animate-spin" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M41.9 23.9c-.3-6.1-4-11.8-9.5-14.4-6-2.7-13.3-1.6-18.3 2.6-4.8 4-7 10.5-5.6 16.6 1.3 6 6 10.9 11.9 12.5 7.1 2 13.6-1.4 17.6-7.2-3.6 4.8-9.1 8-15.2 6.9-6.1-1.1-11.1-5.7-12.5-11.7-1.5-6.4 1.5-13.1 7.2-16.4 5.9-3.4 14.2-2.1 18.1 3.7 1 1.4 1.7 3.1 2 4.8.3 1.4.2 2.9.4 4.3.2 1.3 1.3 3 2.8 2.1 1.3-.8 1.2-2.5 1.1-3.8 0-.4.1.7 0 0z"></path>
                        </g>
                    </svg>
                </button>
            </div>

        </form>
    </div>

    <!-- delete modal -->
    <div class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 overflow-y-auto scrollbar p-5 md:p-16" :class="{ 'invisible bg-black/35' : !deleteModal, 'visible bg-black/65' : deleteModal }" @click="deleteModal = false">
        <form @submit.prevent="deleteApi()" class="bg-white rounded-2xl min-w-full sm:min-w-[450px] p-5 sm:p-10 duration-500 origin-top" :class="{ '-translate-y-1/2 opacity-0' : !deleteModal, 'translate-y-0 opacity-100' : deleteModal }" @click.stop>

            <!-- manage modal body part -->
            <div class="mb-5 flex justify-center items-center flex-col">

                <!-- manage modal icon part -->
                <svg viewBox="0 0 24 24" class="size-[75px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M4 7H20" class="stroke-rose-600" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path class="stroke-rose-600" d="M6 10L7.70141 19.3578C7.87432 20.3088 8.70258 21 9.66915 21H14.3308C15.2974 21 16.1257 20.3087 16.2986 19.3578L18 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path class="stroke-rose-600" d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>

                <!-- manage modal body title part -->
                <div class="mt-3 text-[18px] sm:text-[21px] text-center text-rose-600"> Are you sure? </div>

            </div>

            <!-- manage modal footer part -->
            <div class="flex justify-center items-center gap-2">
                <button type="button" class="min-w-[120px] min-h-[50px] text-[14px] sm:text-[16px] inline-flex justify-center items-center bg-gray-200 text-gray-950 duration-500 hover:bg-gray-600 hover:text-white rounded-xl" @click="closeDeleteModal()">
                    Cancel
                </button>
                <button type="submit" class="min-w-[120px] min-h-[50px] text-[14px] sm:text-[16px] inline-flex justify-center items-center bg-rose-200 text-rose-950 duration-500 hover:bg-rose-950 hover:text-white rounded-xl" v-if="!deleteLoading">
                    Confirm
                </button>
                <button type="button" class="min-w-[120px] min-h-[50px] inline-flex justify-center items-center bg-rose-200 text-rose-950 duration-500 hover:bg-rose-950 hover:text-white group rounded-xl" v-if="deleteLoading">
                    <svg viewBox="0 0 50 50" class="fill-rose-950 duration-500 group-hover:fill-white size-8 animate-spin" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M41.9 23.9c-.3-6.1-4-11.8-9.5-14.4-6-2.7-13.3-1.6-18.3 2.6-4.8 4-7 10.5-5.6 16.6 1.3 6 6 10.9 11.9 12.5 7.1 2 13.6-1.4 17.6-7.2-3.6 4.8-9.1 8-15.2 6.9-6.1-1.1-11.1-5.7-12.5-11.7-1.5-6.4 1.5-13.1 7.2-16.4 5.9-3.4 14.2-2.1 18.1 3.7 1 1.4 1.7 3.1 2 4.8.3 1.4.2 2.9.4 4.3.2 1.3 1.3 3 2.8 2.1 1.3-.8 1.2-2.5 1.1-3.8 0-.4.1.7 0 0z"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </form>
    </div>

</template>

<script>

import axios from "axios";
import {createToaster} from "@meforma/vue-toaster";
const toaster = createToaster({ position: 'top-right' });

export default {

    computed: {

        filteredMovies() {
            return this.tableData.filter((movie) => {
                return !this.keyword || movie.title.toLowerCase().includes(this.keyword.toLowerCase());
            });
        },

        paginatedMovies() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.filteredMovies.slice(startIndex, endIndex);
        },

        totalPages() {
            return Math.ceil(this.filteredMovies.length / this.itemsPerPage);
        },

        visiblePages() {
            const pages = [];
            const total = this.totalPages;
            if ( total <= this.maxVisiblePages + 2) { for (let i = 1; i <= total; i++) { pages.push(i); } }
            else { pages.push(1);
                const start = Math.max(2, this.currentPage - 1);
                const end = Math.min(this.currentPage + 1, total - 1);
                if (start > 2) pages.push("...");
                for (let i = start; i <= end; i++) { pages.push(i); }
                if (end < total - 1) pages.push("...");
                pages.push(total);
            }
            return pages;
        },

    },

    data() {
        return {
            // Data Properties
            formData: {
                title: '',
                description: '',
                release_year: '',
                director: '',
                genre: '',
                rating: 0,
            },
            id: null,
            manageModal: false,
            deleteModal: false,
            rating: 0,
            hoverRating: 0,
            manageLoading: false,
            error: {},
            tableData: [],
            loading: false,
            genres: [
                "Action", "Adventure", "Animation", "Anthology", "Apocalyptic", "Art House", "Biographical", "Black Comedy",
                "Comedy", "Crime", "Cyberpunk", "Dance", "Dark Fantasy", "Detective", "Dystopian", "Documentary", "Drama",
                "Dramedy", "Eco-fiction", "Epic", "Espionage", "Experimental", "Fairy Tale", "Family", "Fantasy", "Fantasy Comedy",
                "Fantasy Romance", "Fable", "Folklore", "Found Footage", "Gangster", "Gothic", "Graphic Novel", "Hard Science Fiction",
                "Heist", "Heroic Fantasy", "Historical", "Historical Fiction", "Horror", "Horror Comedy", "Isekai", "Legal Drama",
                "Light Novel", "Low Fantasy", "Magical Realism", "Martial Arts", "Mecha", "Medical Drama", "Melodrama", "Military",
                "Mockumentary", "Monster Horror", "Musical", "Mystery", "Mythology", "Noir", "Opera", "Paranormal", "Philosophical",
                "Pirate", "Political", "Post-Apocalyptic", "Psychological Horror", "Psychological Thriller", "Realistic Fiction",
                "Religious Fiction", "Road Movie", "Romance", "Romantic Comedy", "Romantic Tragedy", "Samurai", "Satire", "School Life",
                "Science Fantasy", "Science Fiction", "Slice of Life", "Slasher", "Space Opera", "Space Western", "Speculative Fiction",
                "Sports", "Spy Fiction", "Steampunk", "Superhero", "Supernatural", "Survival", "Suspense", "Sword and Sorcery",
                "Thriller", "Time Travel", "Tragedy", "Travelogue", "True Crime", "Urban Fantasy", "Utopian", "Vampire", "War",
                "Werewolf", "Western", "Zombie"
            ],
            priceRange: { min: "", max: "" },
            currentPage: 1,
            itemsPerPage: 10,
            maxVisiblePages: 1,
            keyword: '',
            searchTimeout: null,
            deleteId: null,
            deleteLoading: false,
        }
    },

    mounted() {
        // Mounted Properties
        this.listApi();
    },

    methods: {

        // set rating of manage modal part
        setRating(star) {
            this.rating = star;
            this.formData.rating = star;
        },

        // open manage modal
        openManageModal(data = null) {
            if(data) {
                this.formData.id = data
                this.singleApi(data);
            } else {
                this.formData = {
                    title: '',
                    description: '',
                    release_year: '',
                    director: '',
                    genre: '',
                    rating: 0,
                };
            }
            this.manageModal = true;
        },

        // close manage modal
        closeManageModal() {
            this.manageModal = false;
        },

        // open delete modal
        openDeleteModal(data) {
            this.deleteId = data;
            this.deleteModal = true;
        },

        // close delete modal
        closeDeleteModal() {
            this.deleteModal = false;
        },

        // List api
        async listApi() {
            this.loading = true;
            axios.get('/api/movies',{ headers: { 'Content-Type': 'application/json; charset=utf-8' }}).then( async (response) => {
                this.tableData = response.data;
            }).catch(error => {
                this.error = error.response.data;
            }).finally(() => {
                this.loading = false;
            });
        },

        // search data api
        async searchData() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.listApi();
            }, 500);
        },

        // manage api
        async manageApi() {
            if(this.formData.id) {
                await this.updateApi();
            } else {
                await this.createApi()
            }
        },

        // create api
        async createApi() {
            this.manageLoading = true;
            axios.post(`/api/movies`, this.formData, {headers: { 'Content-Type': 'application/json; charset=utf-8' }}).then( (response) => {
                toaster.success('Movie added successfully');
                this.listApi();
                this.formData = { title: '', description: '', release_year: '', director: '', genre: 'select-genre', rating: 0 };
                this.closeManageModal();
            }).catch(error => {
                this.error = error.response.data
            }).finally(()=>{
                this.manageLoading = false;
            })
        },

        // update api
        async updateApi() {
            this.manageLoading = true;
            axios.put(`/api/movies/${this.formData.id}`, this.formData, {headers: { 'Content-Type': 'application/json; charset=utf-8' }}).then( (response) => {
                toaster.success('Movie updated successfully');
                this.listApi();
                this.formData = { title: '', description: '', release_year: '', director: '', genre: 'select-genre', rating: 0 };
                this.closeManageModal();
            }).catch( error => {
                this.error = error.response.data
            }).finally(()=>{
                this.manageLoading = false;
            })
        },

        // delete api
        async deleteApi() {
            this.deleteLoading = true;
            axios.delete(`/api/movies/${this.deleteId}`, {headers: { 'Content-Type': 'application/json; charset=utf-8' }}).then( (response) => {
                toaster.success('Movie deleted successfully');
                this.listApi();
                this.closeDeleteModal();
            }).finally(()=>{
                this.deleteLoading = false;
            })
        },

        // single api
        async singleApi(data) {
            this.manageLoading = true;
            axios.get(`/api/movies/${data}`, {headers: { 'Content-Type': 'application/json; charset=utf-8' }}).then( (response) => {
                this.formData = response.data
                this.rating = parseInt(response.data.rating)
            }).catch( error => {
                this.error = error.response.data
            }).finally(()=>{
                this.manageLoading = false;
            })
        },

        // change page
        changePage(page) {
            if (page === "...") return;
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },

        // next page
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        // previous page
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

    }

}

</script>
