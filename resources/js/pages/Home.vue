<template>
    <el-container class="page page__home">
        <el-container>
            <el-aside style="padding: 20px;">
                <el-form status-icon label-position="top" label-width="120px" @submit="searchParams">
                    <el-form-item label="Name" prop="pass">
                        <el-input prefix-icon="el-icon-search"
                                  placeholder="Enter house name"
                                  v-model="name"
                                  @input="searchParams"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Bedrooms" prop="pass">
                        <el-input-number v-model="bedroom" :min="1" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Bathrooms" prop="pass">
                        <el-input-number v-model="bathroom" :min="1" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Storeys" prop="pass">
                        <el-input-number v-model="storey" :min="1" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Garage" prop="pass">
                        <el-input-number v-model="garage" :min="1" @change="searchParams"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Price" prop="pass">
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
                style="width: 100%">
                <el-table-column
                    prop="name"
                    label="Name"
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
            bedroom: 1,
            bathroom: 1,
            storey: 1,
            garage: 1,
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
