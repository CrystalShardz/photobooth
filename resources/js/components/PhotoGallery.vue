<template>
    <div class="photo-gallery flex-container">
        <div ref="topRow" class="row">
            <h1 class="title text-center">
                Photo Booth
            </h1>
        </div>
        <div class="row grow-1 center-center">
            <div class="polaroid">
                <img
                    ref="image"
                    alt="Photobooth Photo"
                    :src="currentPhoto"
                    :width="imageSizes.width"
                    :height="imageSizes.height"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            photos: [],
            currentPhotoIndex: 0,
            imageSizes: {
                width: 0,
                height: 0,
            },
        };
    },
    computed: {
        currentPhoto: function () {
            return this.photos[this.currentPhotoIndex];
        }
    },
    mounted() {
        const maxWidth = window.screen.width / 2;
        const maxHeight = (window.screen.height / 2);

        this.imageSizes = this.calculateAspectRatioFit(1440, 900, maxWidth, maxHeight);

        this.fetchImages();

        window.setInterval(() => {
            this.fetchImages();
        }, 10000); // 5 minutes = 300000

        window.setInterval(() => {
            this.currentPhotoIndex += 1;
            if (this.currentPhotoIndex >= this.photos.length) {
                this.currentPhotoIndex = 0;
            }
        }, 7000);
    },
    methods: {
        fetchImages() {
            axios.get('/api/gallery')
                 .then(response => {
                     this.photos = response.data
                 })
                 .catch(error => {
                     alert('Something went wrong refreshing the gallery.');
                 });
        },
        randomSize(min, max) {
            return 400;
        },

        /**
         * Conserve aspect ratio of the original region. Useful when shrinking/enlarging
         * images to fit into a certain area.
         *
         * @param {Number} srcWidth width of source image
         * @param {Number} srcHeight height of source image
         * @param {Number} maxWidth maximum available width
         * @param {Number} maxHeight maximum available height
         * @return {Object} { width, height }
         */
        calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {

            let ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

            return {width: srcWidth * ratio, height: srcHeight * ratio};
        }
    }
}
</script>

<style lang="scss" scoped>
.title {
    font-family: 'markerPen';
    font-size: 5rem;
    text-align: center;
    margin: 0;
    padding: 0;
}

.center-center {
    display: flex;
    align-items: center;
    justify-content: center;
}

.polaroid {
    padding: 1rem;
    padding-bottom: 3.5rem;
    background-color: white;
}
</style>
