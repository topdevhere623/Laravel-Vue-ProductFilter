<template>
    <div class="file-input">
        <input
            :id="label"
            type="file"
            accept="image/png,image/jpeg"
            @change="handleUpload($event.target.files[0])"
        />
        <img
            :src="this.url"
        />

        <label :for="label">
            <div v-if="loading" class="d-flex align-center justify-center">
                <v-progress-circular
                    color="secondary"
                    indeterminate
                ></v-progress-circular>
            </div>
            <span v-else> {{ label }}</span>
            <div v-if="error" class="text-caption error--text">
                {{ error }}
            </div>
        </label>
    </div>
</template>

<script>

import { mapActions } from "vuex";
export default {
    components: {},
    name: "CustomFileUpload",
    props: {
        directory: {
            default: "images",
        },
        value: {
            required: true,
        },
        label: {
            required: true,
        },
        error: {
            required: false,
        },
    },
    data() {
        return {
            fileName: null,
            url: '',
            path: '',
            loading: false,
        };
    },
    watch: {
        value(val) {
            console.log('watch', val);
            if (val !== undefined) {
                this.url = val.url;
                this.path = val.path;
            }
        },
    },
    methods: {
        ...mapActions({
            uploadImage: "uploadImage",
        }),
        async handleUpload(file) {
            console.log('File of Maximus', file);
            if (file) {
                if (file.size > 2097152) {
                    this.$emit("input", {
                        type: this.value.type,
                        error: "max file size 2 mb",
                    });
                    return;
                }
                this.loading = true;
                this.url = URL.createObjectURL(file);
                this.fileName = file.name;

                let form = new FormData();
                form.append("file", file);
                form.append("directory", this.directory);
                let { data } = await window.axios.post("/api/upload", form);

                this.path = data.path;
                this.loading = false;
                this.$emit("input", data.url);
                this.$emit("change");
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.file-input {
    input[type="file"] {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
    display: block;
    width: 100%;
    height: 83%;
    label {
        border: 1px dashed var(--v-dark-lighten2);
        box-sizing: border-box;
        border-radius: 10px;
        width: 100%;
        height: 100%;
        cursor: pointer;
        display: grid;
        place-items: center;
    }
}
</style>
