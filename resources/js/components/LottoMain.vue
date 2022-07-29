<template>
    <div class="w-1/2 border-solid border-zinc-500 border-3 flex flex-col col-span-2 items-center">
        <div class="pb-3 px-6 pt-6">
            <div class="flex space-x-1 w-auto min-w-min">
                <div class="bg-indigo-500 rounded-full shadow-lg flex-none items-center mb-2 w-20 h-20 text-center border-2 border-teal">
                    <p class="font-extrabold text-white text-xl py-6 px-1">{{`${game.take}`+'/'+`${game.name}`}}</p>
                </div>
                <ul class="p-2 bg-white rounded-xl shadow-lg flex items-center space-x-2 mb-2 mx-auto w-full">
                <li v-for="num in result" :key="num" class="rounded-full bg-indigo-500 w-12 h-12 text-center py-3 text-white italic"
                    >{{ num }}</li>
                </ul>
            </div>
            <div class="flex space-x-1 min-w-min">
                <div class="p-2 bg-white rounded-xl shadow-lg flex flex-row items-center space-x-2 mb-2 mx-auto w-full h-20">
                    <p class="bg-indigo-500 w-2/3 text-center py-3 text-white rounded-xl h-16 text-xl">{{ parseFloat(resultInfo.jackpot).toLocaleString("en-US", {style:"currency", currency:"Php"}) }}</p>
                    <div class="flex flex-col w-1/3">
                        <p class="bg-indigo-500 h-8 text-center py-1 text-white rounded-xl">{{ resultInfo.winners }} Winners</p>
                        <p class="bg-indigo-500 h-8 text-center py-1 text-white rounded-xl">{{ resultInfo.draw_date }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col px-6 pb-3">
            <ul class="p-2 bg-white rounded-xl shadow-lg gap-4 mb-2 grid grid-cols-7">
                <li v-for="num in numbers" :key="num" class="rounded-full w-12 h-12 text-center py-3 
                    italic hover:cursor-pointer"
                    :class="[pickedNumbers.includes(num < 10? 0+`${num}`:`${num}`)? 'bg-indigo-500 text-white hover:text-slate-900': 'text-slate-900 bg-indigo-200 hover:text-white hover:bg-indigo-500/75']"
                    @click="pickNumbers(num < 10 ? 0+`${num}`:`${num}`)">{{ num < 10 ? 0+`${num}`:`${num}`}}</li>
            </ul>
            <div class="flex flex-row mb-2 space-x-2">
                <button class="rounded-full bg-gradient-to-r from-indigo-500 to-teal-400 hover:bg-teal-600 text-white h-12 w-1/2" @click="luckyPick(game.name,game.take)">Lucky Pick</button>
                <button class="rounded-full bg-indigo-500 hover:bg-indigo-600 text-white h-12 w-1/2" @click="resetPicks()">Reset</button>
            </div>
            <button class="rounded-full bg-indigo-500 hover:bg-indigo-600 text-white h-12" @click="searchPicks()">Search combination from previous results(10Y)</button>
            
        </div>
    </div>
</template>
<script>

export default {
    props: {
        game: Object,
        latestResult: [Object, String]
    },
    data(){
        return {
            lotto: this.game.name,
            take: this.game.take,
            result: [],
            resultInfo: [],
            numbers: [],
            pickedNumbers: [],
        }
        
    },
    created(){
        this.numbers = this.createNumberArray(this.game.name)
        this.resultInfo = JSON.parse(this.latestResult)
        this.result = JSON.parse(this.resultInfo.combination)
        console.log(this.resultInfo)
    },
    methods:{
        createNumberArray(l){
            var set = []
            while(l--) {
                    set[l] = l+1
            }
            return set
        },
        pickNumbers(a){
            let set = this.pickedNumbers
            if(!set.includes(a)){
                if(set.length > 5){
                    return 'pick only 6'
                }
                set.push(a)
            } else {
                const i = set.indexOf(a)
                if(i > -1){
                set.splice(i,1)
                }
                
            }
            this.pickedNumbers = set.sort()
            console.log(this.pickedNumbers)
        },searchPicks(){
            //alert(JSON.stringify(this.pickedNumbers))
            let picks = this.pickedNumbers
            if(picks.length < 6){
                alert("Combination is less than required");
            }
            let url = '/api/search-results';
            fetch(url, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({'combination':this.pickedNumbers,'game':this.lotto}),
                })
                .then(response => response.json())
                .then(res => {
                    if(res.length > 0) {
                        this.resultInfo = res
                        alert(res[0].draw_date)
                    } else {
                        alert('Non-Existent')
                    }
                })
                .catch((error) => {
                console.error('Error:', error);
                });
        },luckyPick(len,take){
            var set = []
            let a = take
            let pick
            while(a--) {
                pick = Math.floor(Math.random() * len) + 1
                if(set.includes(`${pick}`)){
                    a = a+1
                } else {
                    set[a] = pick < 10? 0+`${pick}`:`${pick}`
                }
            }
            
            this.pickedNumbers = set.sort()
            console.log(this.pickedNumbers)
        },resetPicks(){
            if(this.pickNumbers != []){
                this.pickedNumbers = []
                console.log(this.pickedNumbers)
            }
        },luckyPicks(len,take){
            let mypicks
            let timeout
            // let i = 1
            // while(i--){
                //mypicks = setInterval(this.luckyPick(len,take),3000)
                timeout = setTimeout(this.luckyPick(len,take),100)
            //}
            //this.pickedNumbers = this.pickedNumbers
            //clearInterval(mypicks)
            clearTimeout(timeout)
        },
        
    }
}
</script>
