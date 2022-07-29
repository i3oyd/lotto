<template>
<div class="w-1/2 flex-none grid justify-content-center pt-4 shrink-0">
    <div class="flex flex-col px-6 pb-3 mx-auto shrink-0">
        <div class="text-center py-6"><h1>Study in the Last Ten Years of Data</h1></div>
        <ul class="p-2 bg-white rounded-xl shadow-lg gap-4 mb-2 grid grid-cols-7 w-full">
            <li v-for="stat in numstat" :key="stat.number" class="relative shrink-0">
                <p class="rounded-full w-12 h-12 text-center py-3 italic"
                :class="[mostnum.includes(stat.num_str)? 'bg-indigo-500 text-white': leastnum.includes(stat.num_str)? 'bg-teal-500':'bg-indigo-200 text-indigo-800']">{{ stat.num_str }}</p>
                <p class="rounded-full bg-indigo-400 w-7 h-7 text-center text-white text-xs italic py-1.5 px-1 border-1 border-indigo-900
                    absolute -top-3 -right-3">{{ stat.count }}</p>
            </li>
        </ul>
        <ul>
            <li class="flex flex-row items-center"><p class="rounded-full w-7 h-7 text-center p-3 italic bg-indigo-500"></p><p>Most common numbers</p></li>
            <li class="flex flex-row items-center"><p class="rounded-full w-7 h-7 text-center p-3 italic bg-teal-500"></p><p>Least common numbers</p></li>
            <li class="m-auto"><p>No repeat result</p></li>
        </ul>
    </div>
</div>
</template>
<script>
export default {
    props: {
        stats: [Object, String]
    },
    data(){
        return {
            numstat: [],
            mostnum: [],
            leastnum: []
        }
    },
    created(){
        console.log(JSON.parse(this.stats))
        let num_stat = JSON.parse(this.stats)
        this.numstat = num_stat[0]
        console.log(num_stat[3])
        this.mostnum = num_stat[1]
        this.leastnum = num_stat[2]
        //console.log(this.mostnum)
    },
    methods: {
        createNumberArray(l){
            var set = []
            while(l--) {
                    set[l] = l+1
            }
            return set
        },
        sortStat(){
            
        }
    }
}
</script>