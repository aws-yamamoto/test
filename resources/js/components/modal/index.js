/**
 * モーダル処理を行うミックスイン
 */
import Vue from 'vue'

/**
 * デフォルトの OK ボタンとキャンセルボタンを返す関数
 */
function getDefaultButtons() {
  return [
    { label: '閉じる', classes: 'btn btn-light', resultSelector: () => false },
    { label: 'OK', classes: 'btn theme-color', resultSelector: val => val },
  ]
}

export default {
  methods: {
    /**
     * 確認モーダル
     * @param {Object} props モーダルに表示させるデータ
     */
    showConfirmModal(props) {
      const actualProps = {
        type: 'ConfirmModal',
        state: props.state,
        title: props.title,
        content: props.content,
        buttons: props.buttons,
      }
      return this.showModal(actualProps)
    },
    /**
     * データ読み込みエラーモーダル
     */
    showErrorReadDataModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: 'データ読み込みエラー',
        content: 'データを読み込めませんでした。',
        buttons: [
          { label: 'キャンセル', classes: 'btn btn-light' },
          { label: 'OK', classes: 'btn btn-primary' },
        ],
      }
      return this.showModal(actualProps)
    },
    /**
     * キャンセルモーダル
     */
    showCancelModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: 'キャンセル確認',
        content: 'キャンセルしてもよろしいですか？\n入力内容は保存されません。',
        buttons: [
          { label: 'キャンセル', classes: 'btn btn-light' },
          { label: 'OK', classes: 'btn btn-primary' },
        ],
      }
      return this.showModal(actualProps)
    },
    /**
     * 保存確認モーダル
     */
    showConfirmSaveModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: '保存確認',
        content: '入力した内容で保存してもよろしいですか？',
        buttons: [
          { label: 'キャンセル', classes: 'btn btn-light' },
          { label: 'OK', classes: 'btn btn-primary' },
        ],
      }
      return this.showModal(actualProps)
    },
    /**
     * 保存完了モーダル
     */
    showFinishedSaveModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: '保存完了',
        content: '保存が完了しました。',
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * 登録処理失敗モーダル
     */
    showFailuredSaveModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: 'エラー',
        content: '登録処理に失敗しました。',
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * 削除確認モーダル
     */
    showConfirmDeleteModal(target) {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: '削除確認',
        content: `${target}を削除してもよろしいですか？`,
        buttons: [
          { label: 'キャンセル', classes: 'btn btn-light' },
          { label: '削除', classes: 'btn btn-danger' },
        ],
      }
      return this.showModal(actualProps)
    },
    /**
     * 削除完了モーダル
     */
    showFinishedDeleteModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: '削除完了',
        content: '削除が完了しました。',
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * 削除処理失敗モーダル
     */
    showFailuredDeleteModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: 'エラー',
        content: '削除処理に失敗しました。',
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * 画像アップロード失敗モーダル
     */
    showFailuredUploadImageModal() {
      const actualProps = {
        type: 'ConfirmModal',
        state: 'info',
        title: 'エラー',
        content: '画像アップロードに失敗しました。',
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * ヘルプモーダル(画像あり)
     *
     * @param {Object} props モーダルに表示させるデータ
     */
    showHelpModal(props) {
      const actualProps = {
        type: 'HelpModal',
        state: 'info',
        title: props.title,
        content: props.content,
        message: props.message,
        isCarousel: props.isCarousel,
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * ヘルプモーダル
     *
     * @param {Object} props モーダルに表示させるデータ
     */
    showTextHelpModal(props) {
      const actualProps = {
        type: 'HelpModal',
        state: 'info',
        title: props.title,
        content: props.content,
        buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
      }
      return this.showModal(actualProps)
    },
    /**
     * 商品コピーモーダル
     *
     * @param {Object} props モーダルに表示させるデータ
     */
    showCreateProductForCopyModal(props) {
      const actualProps = {
        type: 'CreateProductForCopyModal',
        state: 'info',
        title: '商品をコピーして新規追加',
        products: props.products,
        buttons: [
          {
            label: 'キャンセル',
            classes: 'btn btn-light',
            resultSelector: () => false,
          },
          {
            label: 'OK',
            classes: 'btn btn-primary',
            resultSelector: modal => modal.selectedProductId,
          },
        ],
      }
      return this.showModal(actualProps)
    },
    /**
     * モーダル表示
     * @param {Object} props
     */
    showModal(props) {
      return new Promise(resolve => {
        props.type = props.type || 'ConfirmModal'
        const Dialog = Vue.component('modal-dialog', require(`./${props.type}.vue`).default) // eslint-disable-line import/no-dynamic-require
        let dialog = new Dialog()
        const defaultButtons = getDefaultButtons()

        props.buttons = (props.buttons || defaultButtons || props.cancelButton).map((b, index) => {
          const n = index < defaultButtons.length ? index : defaultButtons.length - 1

          if (typeof b === 'string') b = { label: b }

          const label = Object.prototype.hasOwnProperty.call(b, 'label')
            ? b.label
            : defaultButtons[n].label

          const classes = Object.prototype.hasOwnProperty.call(b, 'classes')
            ? b.classes
            : defaultButtons[n].classes

          const resultSelector = Object.prototype.hasOwnProperty.call(b, 'resultSelector')
            ? b.resultSelector
            : defaultButtons[n].resultSelector

          return {
            label,
            classes,
            callback: () => {
              resolve(resultSelector(dialog))
              document.body.removeChild(dialog.$el)
              dialog.$destroy()
              dialog = null
            },
          }
        })

        Object.keys(props)
          .filter(x => x in dialog)
          .forEach(x => {
            this.$set(dialog, x, props[x])
          })

        dialog.$mount()
        document.body.appendChild(dialog.$el)

        this.$nextTick(() => {
          const dialogButtons = dialog.$refs.buttonElements
          if (dialogButtons && dialogButtons.length > 0) {
            dialogButtons[0].focus()
          }
        })
      })
    },
  },
}
