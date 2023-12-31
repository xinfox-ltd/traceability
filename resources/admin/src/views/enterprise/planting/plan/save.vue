<template>
    <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
        <el-form :model="form" :rules="rules" ref="dialogForm" label-width="120px" label-position="right">
            <el-form-item label="计划名称" prop="name">
                <el-input v-model="form.name" clearable></el-input>
            </el-form-item>
            <el-form-item label="基地" prop="production_base_id">
                <sc-table-select v-model="productionBase.value" :apiObj="productionBase.apiObj"
                    :params="productionBase.params" :table-width="700" clearable collapse-tags collapse-tags-tooltip
                    :props="productionBase.props" @change="onProductionBaseChange">
                    <template #header="{ form, submit }">
                        <el-form :inline="true" :model="form">
                            <el-form-item>
                                <el-input v-model="form.keyword" placeholder="基地名称" clearable></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="submit">查询</el-button>
                            </el-form-item>
                        </el-form>
                    </template>
                    <el-table-column label="基地名称" prop="name" width="200"></el-table-column>
                    <el-table-column label="地区" prop="region" width="120"></el-table-column>
                    <el-table-column prop="created_at" label="添加时间"></el-table-column>
                </sc-table-select>
            </el-form-item>
            <el-form-item label="产品" prop="product_id">
                <sc-table-select v-model="product.value" :apiObj="product.apiObj" :params="product.params"
                    :table-width="700" clearable collapse-tags collapse-tags-tooltip :props="product.props"
                    @change="onProductChange">
                    <template #header="{ form, submit }">
                        <el-form :inline="true" :model="form">
                            <el-form-item>
                                <el-input v-model="form.keyword" placeholder="产品名称" clearable></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="submit">查询</el-button>
                            </el-form-item>
                        </el-form>
                    </template>
                    <el-table-column label="产品名称" prop="product_name" width="250"></el-table-column>
                    <el-table-column label="品牌/商标" prop="trademark.name" width="100"></el-table-column>
                    <el-table-column prop="created_at" label="添加时间"></el-table-column>
                </sc-table-select>
            </el-form-item>
            <el-form-item label="负责人" prop="staff_id">
                <sc-table-select v-model="staff.value" :apiObj="staff.apiObj" :params="staff.params" :table-width="700"
                    clearable collapse-tags collapse-tags-tooltip :props="staff.props" @change="onStaffChange">
                    <template #header="{ form, submit }">
                        <el-form :inline="true" :model="form">
                            <el-form-item>
                                <el-input v-model="form.keyword" placeholder="姓名" clearable></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="submit">查询</el-button>
                            </el-form-item>
                        </el-form>
                    </template>
                    <el-table-column label="姓名" prop="name" width="150"></el-table-column>
                    <el-table-column label="电话" prop="phone" width="120"></el-table-column>
                    <el-table-column prop="created_at" label="添加时间"></el-table-column>
                </sc-table-select>
            </el-form-item>
            <el-form-item label="计划结束日期" prop="end_date">
                <el-date-picker v-model="form.end_date" type="date" value-format="YYYY-MM-DD" placeholder="选择一个日期" />
            </el-form-item>
        </el-form>
        <template #footer>
            <el-button @click="visible = false">取 消</el-button>
            <el-button type="primary" :loading="isSaveing" @click="submit()">保 存</el-button>
        </template>
    </el-dialog>
</template>

<script>
export default {
    emits: ['success', 'closed'],
    data () {
        return {
            mode: "add",
            titleMap: {
                add: '新增种植计划',
                edit: '编辑种植计划',
                show: '查看'
            },
            visible: false,
            isSaveing: false,
            productionBase: {
                value: {},
                apiObj: this.$API.app.productionBase.list,
                params: {},
                props: {
                    label: 'name',
                    value: 'id',
                    keyword: "keyword"
                }
            },
            product: {
                value: {},
                apiObj: this.$API.app.enterprise.product.list,
                params: {},
                props: {
                    label: 'product_name',
                    value: 'id',
                    keyword: "keyword"
                }
            },
            staff: {
                value: {},
                apiObj: this.$API.app.enterprise.staff.list,
                params: {},
                props: {
                    label: 'name',
                    value: 'id',
                    keyword: "keyword"
                }
            },
            //表单数据
            form: {
                name: "",
                production_base_id: "",
                staff_id: 0,
                product_id: "",
                end_date: ""
            },
            //验证规则
            rules: {
                name: [
                    { required: true, message: '请输入计划名称', trigger: 'change' }
                ],
                production_base_id: [
                    { required: true, message: '请选择生产基地' }
                ],
                product_id: [
                    { required: true, message: '请选择产品' }
                ],
                staff_id: [
                    { required: true, message: '请选择负责人' }
                ],
                end_date: [
                    { required: true, message: '请填写计划结束日期' }
                ]
            }
        }
    },
    mounted () {
    },
    methods: {
        //显示
        open (mode = 'add') {
            this.mode = mode;
            this.visible = true;
            return this
        },
        onProductionBaseChange (val) {
            console.log(val);
            this.form.production_base_id = val.id
        },
        onStaffChange (val) {
            console.log(val);
            this.form.staff_id = val.id
        },
        onProductChange (val) {
            this.form.product_id = val.id
        },
        //表单提交方法
        submit () {
            this.$refs.dialogForm.validate(async (valid) => {
                if (valid) {
                    this.isSaveing = true;
                    await this.$API.app.planting.save.post(this.form)
                        .then(res => {
                            this.isSaveing = false;
                            if (res.code == 200) {
                                this.$emit('success')
                                this.visible = false;
                                this.$message.success("操作成功")
                            } else {
                                this.$alert(res.message, "提示", { type: 'error' })
                            }
                        })
                        .catch(() => {
                            this.isSaveing = false;
                        });

                }
            })
        },
        //表单注入数据
        setData (data) {
            Object.assign(this.form, data)
            this.product.value = {
                id: data.product_id,
                product_name: data.product_name,
            }
            this.staff.value = {
                id: data.user_id,
                name: data.staff_name,
            }
            this.productionBase.value = {
                id: data.production_base_id,
                name: data.production_base_name,
            }
        }
    }
}
</script>

<style></style>
