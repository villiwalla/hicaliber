<template>
    <el-container class="page page__home">
        <el-container>
            <el-aside style="padding: 20px;">
                <el-form status-icon label-position="top" label-width="120px" @submit="searchParams">
                    <el-form-item label="Name">
                        <el-input prefix-icon="el-icon-search"
                                  placeholder="Enter house name"
                                  v-model="name"
                                  @input="searchParams"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Bedrooms">
                        <el-input-number v-model="bedroom" placeholder="0" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Bathrooms">
                        <el-input-number v-model="bathroom" placeholder="0" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Storeys">
                        <el-input-number v-model="storey" placeholder="0" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Garage">
                        <el-input-number v-model="garage" placeholder="0" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Price">
                        <el-slider v-model="price" range :min="priceRange[0]" :max="priceRange[1]" @change="searchParams"></el-slider>
                    </el-form-item>
                </el-form>
            </el-aside>
        </el-container>
        <el-main>
            <el-table
                v-loading="loading"
                element-loading-text="Loading..."
                element-loading-spinner="el-icon-loading"
                element-loading-background="rgba(0, 0, 0, 0.8)"
                empty-text="Results not found"
                :data="tableData"
                :default-sort = "{prop: 'name', order: 'descending'}"
                style="width: 100%">
                <el-table-column
                    prop="name"
                    label="Name"
                    sortable
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="bedroom"
                    label="Bedrooms"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="bathroom"
                    label="Bathrooms">
                </el-table-column>
                <el-table-column
                    prop="storey"
                    label="Storeys">
                </el-table-column>
                <el-table-column
                    prop="garage"
                    label="Garage">
                </el-table-column>
                <el-table-column
                    prop="price"
                    label="Price">
                </el-table-column>
            </el-table>
        </el-main>
    </el-container>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            name: '',
            bedroom: '',
            bathroom: '',
            storey: '',
            garage: '',
            price: [],
            priceRange: [],
            tableData: [],
            loading: true,
            firstLoad: true,
        }
    },
    mounted() {
        this.getPriceRange();
        this.search();
        this.loading = false;
    },
    methods: {
        async getPriceRange() {
            const response = await axios.get('http://localhost:8000/api/house/search/priceRange');

            this.price = response.data;
            this.priceRange = response.data;
        },
        getParams() {
            return {
                name: this.name,
                bedroom: this.bedroom,
                bathroom: this.bathroom,
                storey: this.storey,
                garage: this.garage,
                priceFrom: this.price[0],
                priceTo: this.price[1],
            }
        },
        search(params) {
            this.loading = true;

            axios.get('http://localhost:8000/api/house/search', {params: params})
                .then(response => {
                    this.tableData = response.data.data;
                    this.loading = false;
                })
                .catch(errors => errors)
        },
        searchParams() {
            this.search(this.getParams());
        }
    }
}
</script>

<style scoped>

</style>
