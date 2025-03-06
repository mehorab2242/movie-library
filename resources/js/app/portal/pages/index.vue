<template>

    <div class="w-full h-screen bg-blue-950 p-10">
        <div class="w-full h-full bg-white p-10 rounded-2xl">
            <div class="flex justify-between items-center mb-5">
                <div class="w-full max-w-[450px]">
                    <input type="text" name="" id="" class="w-full py-3 px-5 rounded-xl outline-0 border border-gray-400" placeholder="Search here" required autocomplete="off" />
                </div>
                <div class="">
                    <button type="button" class="bg-blue-700 duration-500 hover:bg-blue-950 py-3 px-5 min-w-[110px] outline-0 border-0 text-white rounded-xl">
                        New
                    </button>
                </div>
            </div>
            <div class="h-[calc(100vh-280px)] w-full bg-gray-200 overflow-y-auto rounded-xl">

            </div>
            <div class="flex justify-center items-center mt-5 gap-x-1">
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="size-[20px]" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    1
                </button>
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    2
                </button>
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    3
                </button>
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    4
                </button>
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    5
                </button>
                <button type="button" class="inline-flex justify-center items-center size-[45px] min-w-[45px] min-h-[45px] outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-700 text-gray-950 hover:text-white rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="size-[20px]" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- manage modal -->
    <div class="fixed inset-0 w-full h-full flex justify-center items-center" v-if="manageModal">
        <div class="bg-white rounded-2xl p-10 w-full max-w-[650px] shadow-xl">
            <div class="flex justify-between items-center">
                <div class="">  </div>
                <button type="button" class="size-[35px] min-w-[35px] min-h-[35px] inline-flex justify-center items-center">

                </button>
            </div>
            <div class="mb-5">

            </div>
            <div class="flex justify-end items-center gap-2">
                <button type="button" class="min-w-[120px] min-h-[50px] inline-flex justify-center items-center bg-gray-200 text-gray-950 duration-500 hover:bg-gray-600 hover:text-white rounded-xl">
                    Cancel
                </button>
                <button type="button" class="min-w-[120px] min-h-[50px] inline-flex justify-center items-center bg-blue-200 text-blue-950 duration-500 hover:bg-blue-950 hover:text-white rounded-xl">
                    <span v-if="id === null"> Create </span>
                    <span v-if="id !== null"> Update </span>
                </button>
            </div>
        </div>
    </div>
    <!-- delete modal -->
    <div class="fixed inset-0 w-full h-full flex justify-center items-center" v-if="deleteModal">
        <div class="bg-white rounded-2xl p-10 w-full max-w-[450px] shadow-xl">
            <div class="flex justify-between items-center">
                <div class="">  </div>
                <button type="button" class="size-[35px] min-w-[35px] min-h-[35px] inline-flex justify-center items-center">

                </button>
            </div>
            <div class="mb-5">

            </div>
            <div class="flex justify-center items-center gap-2">
                <button type="button" class="min-w-[120px] min-h-[50px] inline-flex justify-center items-center bg-gray-200 text-gray-950 duration-500 hover:bg-gray-600 hover:text-white rounded-xl">
                    Cancel
                </button>
                <button type="button" class="min-w-[120px] min-h-[50px] inline-flex justify-center items-center bg-rose-200 text-rose-950 duration-500 hover:bg-rose-950 hover:text-white rounded-xl">
                    Confirm
                </button>
            </div>
        </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    data(){
        return {
            formData: {
                title: '',
                description: '',
                release_year: '',
                director: '',
                genre: '',
                rating: '',
            },
            id: null,
            manageModal: false,
            deleteModal: false,
        }
    },
    mounted() {
        this.getListApi();
    },
    methods: {

        // List api
        getListApi() {

        },

        // search data api
        async searchData() {

        },

        // create api
        async createApi() {

        },

        // update api
        async updateApi() {

        },

        // delete api
        async deleteApi() {

        },

        openManageModal() {

        },

        closeManageModal() {

        },

        openDeleteModal() {

        },

        closeDeleteModal() {

        },


    }
}

</script>
