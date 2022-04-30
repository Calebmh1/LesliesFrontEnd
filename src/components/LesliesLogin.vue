<template>
    <div>
    <slot></slot>
        <form>
            <fieldset>
                <form>
                    <legend>{{ legend }}</legend>
                    <h2>{{currentDate()}}</h2>
                    <h2>{{currentTime()}}</h2>
                    <label> Enter Employee ID: <input type="text" v-model="callID" required ></label>
                    <button v-on:click.prevent="generateCall()">Punch In</button>
                </form>
            </fieldset>
        </form>
    </div>
</template>



<script>
    //import store from "@/store/index.js";

export default {
    name: "LesliesLogin",
    callID: "",
    props: {
        legend: {
            type: String,
            default: "Welcome",
        }
    },
    data: function() {
        return {
            callID: "",
        }
    },
    methods: {
        generateCall: function() {
            if(!this.callID) {
                var call = null
            }else {
                call = "https://leslieswarehouseapi20220422190240.azurewebsites.net/api/Employees/" + this.callID;
                this.getEmpInfo(call);
            }  
        },
        currentTime: function() {
            return new Date().toLocaleTimeString();
        },
        currentDate: function() {
            return new Date().toLocaleDateString();
        },
        getEmpInfo: function(call) {
            var vm = this;
            fetch(call,{
                method: "GET",
            })
            .then(response => response.json())
            .then(function(data){
                vm.empInfo = data;

                console.log(vm.empInfo);
            });
    },
},
}

</script>

<style scoped>
    fieldset {
        background-color: lightblue;
        max-width: 300px;
        margin: auto;
        padding: 20px;
    }
    legend {
        font-weight: bold;
        color: white;
        background: blueviolet;
        padding: 5px;
        border: solid 1px black;
        font-size: 1.2em;
    }
    label {
        display: block;
        margin-bottom: 5px;
        
    }
    button{
        color: white;
        background: blueviolet;
        font-size: 1.2em;
        font-weight: bold;
    }
    form{
        
        background: white;
        padding: 10px;
    }
    h2{
        padding: 5px;
    }
    input{
        padding: 5px;
        margin: 10px;
    }

</style>