<template>
  <div class="billing-system">
    <div class="switch">
      <button style="float:right;" @click="productPage">Product</button><br><br>
      <button style="float:right;" @click="memberPage">Member</button>
    </div>
    <div class="header">
      <h1>Billing System</h1>
    </div>

    <div class="customer-info">
      <h2>Customer Information</h2>
      <label for="customer-contact">Contact:</label>
      <input type="number" id="customer-contact" placeholder="Enter customer contact" v-model="customerContact" />
    </div>

    <div class="product-list">
      <h2>Product List</h2>
      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Add to Cart</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>{{ product.name }}</td>
            <td>{{ product.price }}</td>
            <td><input type="number" v-model="product.quantity" min="1" /></td>
            <td>{{ product.price * product.quantity }}</td>
            <td>
              <button @click="addToCart(product)">Add</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="cart">
      <h2>Cart</h2>
      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in cart" :key="index">
            <td>{{ item.name }}</td>
            <td>{{ item.quantity }}</td>
            <td>{{ item.price }}</td>
            <td>{{ item.total }}</td>
            <td>
              <button @click="removeFromCart(index)">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="totals">
        <h3>Subtotal: {{ subtotal.toFixed(2) }}</h3>
        <h3>Discount (%): <input type="number" v-model="discount" min="0" max="100" placeholder="Discount (%)" /></h3>
        <h3>Tax (10%): {{ tax.toFixed(2) }}</h3>
        <h3>Total: {{ total.toFixed(2) }}</h3>
      </div>
    </div>

    <div class="payment">
      <h2>Payment</h2>
      <label for="payment-method">Payment Method:</label>
      <select id="payment-method" v-model="paymentMethod">
        <option value="cash">Cash</option>
        <option value="card">Card</option>
        <option value="digital-wallet">Digital Wallet</option>
      </select>
      <h2>Invoice</h2>
      <button @click="generateInvoice">Generate Invoice</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: ['products'],
  data() {
    return {
      cart: [],
      subtotal: 0,
      discount: 0,
      taxRate: 0.1,
      paymentMethod: '',
      customerContact: '',
    };
  },
  computed: {
    discountAmount() {
      return (this.discount / 100) * this.subtotal;
    },
    tax() {
      return Math.max(0, this.subtotal - this.discountAmount) * this.taxRate;
    },
    total() {
      return this.subtotal - this.discountAmount + this.tax;
    },
  },
  methods: {
    calculateTotal(product) {
      return product.price * product.quantity;
    },
    addToCart(product) {
      let cartProduct = this.cart.find((item) => item.id === product.id);
      if (cartProduct) {
        cartProduct.quantity += product.quantity;
        cartProduct.total = this.calculateTotal(cartProduct);
      } else {
        this.cart.push({ ...product, total: this.calculateTotal(product) });
      }
      product.quantity = 1;
      this.calculateSubtotal();
    },
    removeFromCart(index) {
      this.cart.splice(index, 1);
      this.calculateSubtotal();
    },
    calculateSubtotal() {
      this.subtotal = this.cart.reduce((acc, item) => acc + item.total, 0);
    },
      generateInvoice() {
        if (this.cart.length === 0) {
          alert('Cart is empty. Please add products.');
        return;
      }
        if (!this.paymentMethod) {
          alert('Please select a payment method.');
          return;
        }
      axios.post('/gen-invoice', {
          cart: this.cart,
          subtotal: this.subtotal,
          discount: this.discount,
          taxRate: this.taxRate,
          paymentMethod: this.paymentMethod,
          customerContact:this.customerContact
        })
        .then((resp) => {
            const filename = resp.data.bill;          
            window.open('/print/' +filename, '_blank');
        })
        .catch((error) => {
          alert('Billing Failed. Please bill again.');
        });
    },
    productPage(){
      window.open('/pro', '_blank');
    },
    memberPage(){
      window.open('/mem', '_blank');
    }
  },
};
</script>


<style scoped>
.billing-system {
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
    padding: 5px;
    margin: 2px;
    border-radius: 5px;
}

.customer-info,
.product-list{
    overflow: auto;
}
.cart,
.payment,
.invoice {
  margin: 10px;
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

.totals {
  text-align: right;
}
</style>
