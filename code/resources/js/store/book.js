
const state = {
    all_books: [],
    book: {}
}

// stateの直接参照は非推奨なのでgettersに定義してコール
const getters = {
}

// commit("呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期のみ)
const mutations = {

    setAllBooks(state, books){
        state.all_books = books
    },

    setBook(state, book){
        state.book = book
    }
}

// dispatch("モジュール名/呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期/非同期)
const actions = {

    async getAllBooks(context) {

        await axios.get("/api/books/all") // 戻り値をJSONで取得
        .then((response) => {
            context.commit("setAllBooks", response.data)
        })
    },

    getBookById(context, book_id){

        const books = context.state.all_books

        books.forEach((book) => {

            if(book.id == book_id){
                context.commit("setBook", book)
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
    },

    // 貸出処理(isbn, auth_user)
    async borrowBook({context}, {isbn, auth_user, dest}){

        if(!isbn){
            return alert("本データを取得してください。")
        }
        if(!auth_user){
            return alert("ログインもしくは顔認証してください。")
        }

        var path = "/api/books/" + isbn + "/borrow/" + auth_user.id

        await axios.get(path)
        .then((response) => {

            if(response.data == "ng"){
                return alert("本が登録されていません。")
            }
            // TODO: adminのみ本を登録しますか？から登録画面へ

            // 返却日を表示
            var today = new Date()
            today.setDate(today.getDate() + 14)
            var return_date = today.toLocaleDateString()
            var message = `貸出し登録が完了しました！\n返却日は${return_date}です。`
            alert(message)

            location.href = dest
            return
        })
    },

    // 返却処理
    async returnBook(context, book) {

        await axios.get("/api/books/return/" + book.id)
        .then((response) => {

            confirm("返却しますか？")
            location.reload()
            return
        })
        .catch((error) => {
            alert("エラーが発生しました。")
            console.log(error.name + ": " + error.message)
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
