<template>
    <div ref="photobooth">
        <camera
            :width="screenWidth"
            :height="screenHeight"
            :enabled="cameraEnabled"
            @phototaken="handlePhotoTakenEvent"
        ></camera>

        <transition name="fade">
            <polaroid
                :photo="photo"
                :is-visible="photoTaken"
                @sendEmail="showEmailWindow"
                @newPhoto="takeNewPhoto"
            ></polaroid>
        </transition>
        <transition name="fade">
            <email-modal :is-visible="isEmailModalVisible"></email-modal>
        </transition>
    </div>
</template>

<script>

import EmailModal from "./EmailModal";
import Polaroid from "./Polaroid";
import Bus from "../bus";

export default {
    components: {Polaroid, EmailModal},
    data() {
        return {
            width: 1440,
            height: 900,
            cameraEnabled: true,
            photoTaken: false,
            photo: '',
            isEmailModalVisible: false,
            screenWidth: 1440,
            screenHeight: 900,
        };
    },
    created() {
        Bus.$on('showEmailModal', () => {
            this.showEmailWindow();
        });
        Bus.$on("emailSent", () => {
            this.takeNewPhoto();
        });
    },
    mounted() {
        this.screenWidth = window.screen.width;
        this.screenHeight = window.screen.height;
        window.addEventListener('resize', () => {
            this.screenWidth = window.screen.width;
            this.screenHeight = window.screen.height;
        });
        document.documentElement.requestFullscreen()
                .catch(error => {
                    console.error(error);
                }).then(() => {
            this.screenWidth = window.screen.width;
            this.screenHeight = window.screen.height;
        });
    },
    methods: {
        handlePhotoTakenEvent(photo) {
            console.log("PHOTO TAKEN EVENT CAUGHT");
            this.cameraEnabled = false;
            this.photo = photo;
            this.photoTaken = true;
            this.storeImage();
        },
        takeNewPhoto() {
            this.isEmailModalVisible = false;
            this.photoTaken = false;
            this.cameraEnabled = true;
        },
        showEmailWindow() {
            this.isEmailModalVisible = true;
        },
        storeImage() {
            axios.post('/api/store', {
                photo: this.photo
            })
                 .then(response => {
                     console.log(response.data);
                 })
                 .catch(error => {
                     alert("Failed to save image!");
                 });
        },
    }
}
</script>

<style lang="scss" scoped>

.modal-buttons {
    text-align: center;
}

.fade-enter-active {
    transition: opacity 2s;
}

.fade-enter, .fade-leave-to {
    opacity: 1;
}
</style>
