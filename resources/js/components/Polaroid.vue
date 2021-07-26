<template>
    <div v-show="visible" class="polaroid">
        <div class="polaroid-window">
            <div class="polaroid-body">
                <img :src="photo" width="1440" height="900"/>
            </div>
            <div class="polaroid-footer">
                Beth &amp; Phil's Wedding - 15<sup>th</sup> July 2021
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <button class="button is-info" @click="triggerEmail">
                    Send To Me
                </button>
            </div>
            <div class="column">
                <button class="button is-primary" @click="triggerNewPhoto">
                    New Photo
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Bus from '../bus';

export default {
    props: {
        photo: null,
        isVisible: {
            type: Boolean,
            required: true,
            default: false,
        }
    },
    data() {
        return {
            visible: false,
        }
    },
    watch: {
        isVisible: function (newValue) {
            this.visible = newValue;
        },
    },
    mounted() {
        this.visible = this.isVisible;
    },
    methods: {
        showEmailWindow() {
            Bus.$emit('showEmailModal');
        },
        triggerEmail() {
            this.$emit('sendEmail');
        },
        triggerNewPhoto() {
            this.$emit('newPhoto');
        }
    }
}
</script>

<style lang="scss" scoped>
.polaroid {
    background-color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 100;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    flex-direction: column;
}

.polaroid-window {
    width: 1024px;
    -webkit-box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.31);
    box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.31);
    padding: 1rem;
    margin-bottom: 2rem;

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}

.polaroid-body {
    margin-bottom: 1rem;
}

.polaroid-footer {
    text-align: center;
    font-family: "markerPen";
    font-size: 2.5rem;
}
</style>
