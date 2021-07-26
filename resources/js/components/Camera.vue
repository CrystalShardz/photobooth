<template>
    <div class="camera-container">
        <div class="countdown-container">
            <circular-count-down-timer
                v-if="isCountingDown"
                :initial-value="5"
                :steps="1"
                @finish="takePhoto"
                second-label=""
            ></circular-count-down-timer>
            <p v-else>
                <a href="#" @click.prevent="startCountdown">Click To Take Photo</a>
            </p>
        </div>
        <video ref="camera" :width="width" :height="height" autoplay></video>
        <canvas ref="canvas" style="display: none;"></canvas>
    </div>
</template>

<script>
import Bus from "../bus";

export default {
    components: {
        //
    },
    props: {
        width: {
            type: Number,
            required: false,
            default: 1440
        },
        height: {
            type: Number,
            required: false,
            default: 900
        },
        enabled: {
            type: Boolean,
            required: true,
        },
    },
    watch: {
        enabled(newVal) {
            if (newVal) {
                this.startCamera();
            } else {
                this.stopCamera();
            }
        }
    },
    data() {
        return {
            audio: null,
            isCountingDown: false,
        };
    },
    created() {
        Bus.$on('camera.takePhoto', () => {
            this.takePhoto();
        });
    },
    mounted() {
        if (this.enabled) {
            this.startCamera();
        }
        if (this.audio === null) {
            this.audio = new Audio('snap.mp3');
        }
    },
    methods: {
        startCamera() {
            const constraints = (window.constraints = {
                audio: false,
                video: {
                    width: this.width,
                    height: this.height,
                }
            });

            navigator.mediaDevices.getUserMedia(constraints)
                     .then(stream => {
                         this.$refs.camera.srcObject = stream;
                     })
                     .catch(error => {
                         console.error(error);
                         alert("Failed to start camera!");
                     });
        },
        stopCamera() {
            let tracks = this.$refs.camera.srcObject.getTracks();
            tracks.forEach(track => {
                track.stop();
            });
        },
        takePhoto() {
            this.audio.play();
            const canvas = this.$refs.canvas;

            canvas.width = this.$refs.camera.videoWidth;
            canvas.height = this.$refs.camera.videoHeight;
            canvas.getContext('2d')
                  .drawImage(
                      this.$refs.camera,
                      0, 0
                  );

            this.$emit('phototaken', canvas.toDataURL('image/jpeg'));
            this.isCountingDown = false;
        },
        startCountdown() {
            this.isCountingDown = true;
        }
    }
}
</script>

<style lang="scss" scoped>
.camera-container {
    position: relative;
}

.countdown-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: red;
    text-align: center;
}

a, a:hover {
    color: red;
}
</style>
