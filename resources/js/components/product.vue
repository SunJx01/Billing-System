<template>
    <div class="product">
        <div class="addProduct">
            <div class="switch">
                <button style="float:right;" @click="billingPage">Billing Page</button><br><br>
            </div>

            <form >
                <h1>Add New Product</h1>
                <input type="text" v-model="newProduct.name" placeholder="Name" required><br>
                <input type="number" v-model="newProduct.price" placeholder="Price" required><br>
                <input type="number" v-model="newProduct.stock" placeholder="Stock" required><br>
                <button type="button" @click="addNewProduct()">Add</button>
            </form>
        </div>
        <div class="addStock">
            <h1>Update Stock</h1>
            <form @submit.prevent="updateStock">
                <select v-model="selectedProduct" id="product">
                    <option v-for="product in products" :key="product.id" :value="product">{{product.name}}</option>
                </select>
                <br><br>
                <input type="number" v-model="newStock" placeholder="New Stock">
                <button type="button" @click="updateNewStock()">Add</button>
            </form>
        </div>
        <div class="Product-detail">
            <h1>Product Details</h1>
            <table>
                <thead>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                </thead>
                <tbody>
                    <tr v-for="(product) in products" :key="product.id">
                        <td>{{ product.name }}</td>
                        <td>{{ product.price }}</td>
                        <td>{{ product.stock }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';  
export default {
    props: ['products'],
    data() {
        return {
            newProduct: {
                name: '',
                price: '',
                stock: '',
            },
            selectedProduct: '',
            newStock: '',
        };
    },
    methods: {
        // addProduct() {
        //     this.products.push({
        //         ...this.newProduct,
        //         id: this.products.length + 1
        //     });
        //     this.newProduct = { name: '', price: 0, stock: 0 };
        // },
        // updateStock() {
        //     if (this.selectedProduct) {
        //         this.selectedProduct.stock = parseInt(this.selectedProduct.stock) + parseInt(this.newStock);
        //         console.log(typeof(this.newStock));
        //          this.newStockUpd = { name: selectedProduct.name,  stock: newStock};
        //     }   
        // },
        editProduct(index) {
            console.log("Editing product at index:", index);
        },
         updateNewStock(){
            axios.post('/update-stock', {newStock :this.newStock, productDet:this.selectedProduct}).then((resp)=>{

        }).catch((error)=>{

        });
         },
        billingPage(){
             window.open('/', '_blank');
        },
         addNewProduct() {
        axios.post('/add-product', {params:this.newProduct}).then((resp)=>{

        }).catch((error)=>{

        });
    }
}}
</script>

<style scoped>
    .product{
        background-color: antiquewhite;
        color: brown;
        display: flex;
        margin: 5%;
        flex-direction: column;
        gap: 20px;
        padding: 15px;
        border-radius: 15px;
        border: 3px solid greenyellow;
        outline: 3px solid antiquewhite;
        outline-offset: 5px;
        overflow: auto;
    }
    input{
        margin: 5px;
        padding: 5px;
        border-radius: 5px;
    }
    button {
        background-color: greenyellow;
        color: brown;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background-color: brown;
        color: white;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid greenyellow;
        padding: 10px;
        text-align: center;
    }

</style>