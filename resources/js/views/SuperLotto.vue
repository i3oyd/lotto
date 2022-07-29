<template>
    <LottoMain :game="{'name':49,'take':6}" :latest-result="latestResult"></LottoMain>
</template>

<script>
import LottoMain from '../components/LottoMain'
export default {
    props: {
        latestResult: [Object, String]
    },
    components: { LottoMain },
}
</script>