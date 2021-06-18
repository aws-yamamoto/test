/**
 * 画像アップロード処理を行うミクッスイン
 */
import imageCompression from 'browser-image-compression'
import httpStatus from '../config/httpStatus'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const UploadImageRepository = RepositoryFactory.get('uploadImages')

export default {
  mixins: [require('../components/modal').default],
  methods: {
    /**
     * 画像プレビュー
     *
     * @param {*} event
     */
    async previewImage(event) {
      if (event.target.files.length === 0) {
        this.onDeleteImage()
        return false
      }

      const imageFile = event.target.files[0]

      if (!imageFile.type.match('image.*')) {
        this.onDeleteImage()
        return false
      }

      const reader = new FileReader()

      reader.onload = e => {
        this.record.image = e.target.result
      }

      reader.readAsDataURL(imageFile)

      // 画像圧縮オプション
      const options = {
        maxSizeMB: 0.5,
        maxWidthOrHeight: 500,
      }
      try {
        // 圧縮画像の生成
        this.imageData = await imageCompression(imageFile, options)
      } catch (e) {
        console.error('getCompressImageFileAsync is error', e)
        throw e
      }
      return null
    },
    /**
     * 画像アップロード処理
     *
     * @param {String} directory S3保存先ディレクトリ名
     */
    async uploadImage(directory) {
      const formData = new FormData()
      formData.append('imageData', this.imageData)
      formData.append('directory', directory)
      formData.append('fileName', this.record.image_name)

      try {
        const response = await UploadImageRepository.upload(formData)

        if (response.status !== httpStatus.CREATED) {
          this.$store.commit('error/setCode', response.status)
          await this.showFailuredUploadImageModal()
          return false
        }

        return response.data
      } catch (e) {
        // 画像アップロード失敗モーダル表示
        await this.showFailuredUploadImageModal()
      }
      return null
    },
  },
}
