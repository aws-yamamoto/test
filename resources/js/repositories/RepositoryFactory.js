import AuthRepository from './admin/AuthRepository'
import RefreshTokenRepository from './admin/RefreshTokenRepository'
import ShopRepository from './admin/ShopRepository'
import InfoItemRepository from './admin/InfoItemRepository'
import ProductCategoryRepository from './admin/ProductCategoryRepository'
import ProductRepository from './admin/ProductRepository'

const repositories = {
  auth: AuthRepository,
  refreshTokens: RefreshTokenRepository,
  shops: ShopRepository,
  infoItems: InfoItemRepository,
  productCategories: ProductCategoryRepository,
  products: ProductRepository,
}

// eslint-disable-next-line import/prefer-default-export
export const RepositoryFactory = {
  get: name => repositories[name],
}
