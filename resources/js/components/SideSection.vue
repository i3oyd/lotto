<template>
    <div class="grid justify-items-center border-solid border-zinc-500 border-2">
        <div class="p-6">
            <table class="table-auto md:table-fixed">
            <thead>
                <tr>
                    <th>GAME</th>
                    <th>COMBINATION</th>
                    <th :class="screen < 1024? 'hidden':''">DRAW DATE</th>
                    <th>PRIZE</th>
                    <th :class="screen < 1024? 'hidden':''">WINNERS</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="(results,index) in JSON.parse(latestResults)" :key="index">
                <td class="bg-white rounded-lg shadow-lg items-center mb-2 h-8 text-center align-middle py-1 px-2">{{ results.game }}</td>
                <td class="p-1 bg-white rounded-full shadow-lg flex flex-row items-center space-x-1 mb-2">
                    <p v-for="(result,i) in JSON.parse(results.combination)" :key="i"  class="rounded-full bg-indigo-500 w-8 h-8 text-center p-1 text-white italic">{{ result }}</p>
                </td>
                <td class="bg-white rounded-lg shadow-lg items-center mb-2 h-8 text-center align-middle py-1 px-2"
                 :class="screen < 1024? 'hidden':''"
                >{{ results.draw_date }}</td>
                <td class="px-2 bg-white rounded-lg shadow-lg items-center space-x-1 h-8 text-indigo-500 font-extrabold">{{ parseFloat(results.jackpot).toLocaleString("en-US", {style:"currency", currency:"Php"}) }}</td>
                <td class=" px-2 bg-white rounded-lg shadow-lg items-center space-x-1 h-8 align-middle"
                :class="screen < 1024? 'hidden':''"
                >{{ results.winners }}</td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="grid justify-items-center border-solid border-zinc-500 border-2">
        <div class="flex flex-col p-6">
            <div v-for="(results,index) in JSON.parse(latestResults)" :key="index" class="flex flex-row space-x-1">
                <div class="flex flex-row">
                    <h2 class="bg-white rounded-lg shadow-lg items-center mb-2 h-8 text-center align-middle py-1 px-2">{{ results.draw_date }}</h2>
                    <h2 class="bg-white rounded-lg shadow-lg items-center mb-2 h-8 text-center align-middle py-1 px-2">{{ results.game }}</h2>
                </div>
                <div v-for="(result,i) in JSON.parse(results.combination)" :key="i" class="p-1 bg-white rounded-full shadow-lg flex items-center space-x-1 mb-2">
                    <p class="rounded-full bg-indigo-500 w-8 h-8 text-center p-1 text-white italic">{{ result }}</p>
                </div>
            </div>
        </div>
    </div> -->
</template>
<script>
export default {
    props: {
        latestResults: [Object, String]
    },
    data(){
        return {
            screen: innerWidth
        }
    },
    created(){
        console.log(innerWidth)
    }
}
</script>