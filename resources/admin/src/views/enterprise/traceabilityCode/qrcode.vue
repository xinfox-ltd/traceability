<template>
    <el-dialog title="二维码" v-model="visible" :width="300" destroy-on-close @closed="$emit('closed')">
        <div style="text-align: center;">
            <sc-qr-code :text="qrcode.url" :size="200"></sc-qr-code>
            <div>No:{{ qrcode.serial_number }}</div>
            <div>Code:{{ qrcode.code }}</div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    data () {
        return {
            visible: false,
            qrcode: {}
        }
    },
    methods: {
        open () {
            this.visible = true;
            return this;
        },
        setData (row) {
            this.qrcode = row
        }
    },
}
</script>