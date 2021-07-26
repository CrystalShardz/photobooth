<template>
    <div ref="modal" class="modal" v-show="visible">
        <div class="modal-card">
            <header class="modal-card-head">
                <h3 class="modal-card-title">Enter Your Email Address</h3>
            </header>
            <section class="modal-card-body">
                <input type="email" v-model="emailAddress" placeholder="hello@example.com"/>
            </section>
            <footer class="modal-card-foot has-text-centered is-align-content-center is-justify-content-center">
                <button type="button" class="button is-primary" @click="sendEmail">Send</button>
            </footer>
        </div>
    </div>
</template>

<script>
import Bus from "../bus";

export default {
    props: {
        isVisible: {
            required: true,
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            emailAddress: '',
            emailSent: false,
            sending: false,
            visible: false,
        };
    },
    watch: {
        isVisible: function (newValue) {
            this.visible = newValue;

            if (newValue) {
                this.showModal();
            } else {
                this.hideModal();
            }
        }
    },
    mounted() {
        if (this.isVisible) {
            this.showModal();
        }
    },
    methods: {
        sendEmail() {
            axios.post('/api/email', {
                email: this.emailAddress
            })
                 .then(response => {
                     console.log(response);
                 })
                 .catch(error => {
                     console.error(error);
                 })
                 .finally(() => {
                     this.hideModal();
                 })
        },
        showModal() {
            this.visible = true;
        },
        hideModal() {
            this.visible = false;
            Bus.$emit("emailSent");
        }
    }
}
</script>

<style lang="scss" scoped>
.modal {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-card {
    width: auto;
    height: auto;
    border-radius: 15px;
}

.modal-card-head {
    padding: 1rem;
    text-align: center;
}

.modal-card-title {
    margin: 0;
    padding: 0;
    font-size: 3rem;
}

.modal-card-body {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal-card-foot {
    padding: 1rem;
    text-align: center;
}

input {
    padding: .5rem;
    border-radius: 5px;
    font-size: 1.5rem;
    border: none;
    outline: none;
}

button {
    border-radius: 5px;
    padding: .5rem;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

.is-primary {
    background-color: dodgerblue;
    color: white;
}
</style>
