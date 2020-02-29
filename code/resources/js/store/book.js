
const state = {
    all_books: [],
    book: {}
}

// stateの直接参照は非推奨なのでgettersに定義してコール
const getters = {
}

// commit("呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期のみ)
const mutations = {

    setAll(state, books){
        state.all_books = books
    },

    set(state, book){
        state.book = book
    }
}

// dispatch("モジュール名/呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期/非同期)
const actions = {

    async getAllBooks(context) {

        await axios.get("/api/books/all") // 戻り値をJSONで取得
        .then((response) => {
            context.commit("setAll", response.data)
        })
        .catch((error) => {
            console.log(error.name + ": " + error.message);
        })
    },

    getBookById(context, book_id){

        const books = context.state.all_books

        books.forEach((book) => {

            if(book.id == book_id){
                context.commit("set", book)
                return
            }
        })
    },

    async updateBook(context, book){

        await axios.patch("/api/books", book)
        .then(() => {
            confirm("更新してもよろしいですか？")
            location.reload()
            return
        })
    },

    async destroyBook(context, book){

        // deleteメソッドではdataキーが必要！
        await axios.delete("/api/books", {
            data: { id: book.id }
        })
        .then(() => {
            confirm("削除してもよろしいですか？")
            location.reload()
            return
        })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
