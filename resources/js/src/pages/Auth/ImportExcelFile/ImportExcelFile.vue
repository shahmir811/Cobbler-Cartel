<template>
    <div class="admin-import-file-wrapping-div">
        <h1 class="admin-import-excel-file-page-title">Import Excel file</h1>

        <b-row class="justify-content-md-center">
            <b-col cols="8">
                <form @submit.prevent="submitUploadFileForm">
                    <div class="form-group">
                        <label
                            for="exampleInputEmail1"
                            class="admin-import-excel-file-label"
                            >Email address</label
                        >
                        <div class="custom-file">
                            <input
                                type="file"
                                class="custom-file-input"
                                id="customFile"
                                @change="onChangeHandler"
                                :class="{ 'is-invalid': errors.import_file }"
                            />

                            <label class="custom-file-label" for="customFile"
                                >Choose file</label
                            >
                        </div>

                        <span class="invalid-feedback" v-if="errors.import_file"
                            ><strong>{{ errors.import_file[0] }}</strong></span
                        >

                        <button
                            class="btn btn-success admin-import-excel-file-submit-button"
                            :disabled="loading"
                        >
                            <template v-if="loading">
                                <div
                                    class="spinner-border text-dark"
                                    role="status"
                                >
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </template>
                            <template v-else>
                                Upload File
                            </template>
                        </button>
                    </div>
                </form>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "ImportExcelFile",
    computed: {
        ...mapGetters({
            loading: "loading",
            errors: "errors"
        })
    },
    data() {
        return {
            excel_file: null
        };
    },
    methods: {
        ...mapActions({
            uploadExcelFile: "uploadExcelFile"
        }),
        onChangeHandler(e) {
            this.excel_file = e.target.files[0];
        },
        submitUploadFileForm(e) {
            if (this.excel_file) {
                const fd = new FormData();
                fd.append("import_file", this.excel_file);
                this.uploadExcelFile(fd);
            }
        }
    }
};
</script>

<style lang="scss">
@import "../../../styles/styles.scss";

.admin-import-excel-file-page-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 15px 0px;
}

.form-group {
    text-align: left !important;

    label {
        color: $BROWN-10;
    }
}

.admin-import-excel-file-label {
    text-align: left;
    color: $BROWN-10;
    margin-bottom: 20px;
    @extend .semibold-16px-24px;
}

.admin-import-excel-file-submit-button {
    width: 117px;
    height: 45px;
    margin-top: 20px;
}

.invalid-feedback {
    display: block;
}
</style>
