<template>
    <div class="member">
        <div class="switch">
            <button style="float:right;" @click="billingPage">Billing Page</button><br><br>
        </div>

        <div class="add-Member">
            <form action="">
                <h1>Add New Member</h1>
                <input type="text" name="name" placeholder="Name"><br>
                <input type="text" name="number" placeholder="Number"><br>
                <input type="text" name="address" placeholder="Address"><br>
                <button>Add</button>
            </form>
        </div>
        <div class="member-detail">
            <table>
                <thead>
                    <th></th>
                </thead>
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
            
        };
    },
    methods: {
        billingPage(){
                  window.open('/', '_blank');
        }
    }
}

</script>


<style scoped>
    .member{
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
        margin: 5px;
    }

    button:hover {
        background-color: brown;
        color: white;
    }

</style>