import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { Category } from 'src/common/database/schemas/category.schema';
import { Order } from 'src/common/database/schemas/order.schema';
import { Product } from 'src/common/database/schemas/product.schema';
import { User } from 'src/common/database/schemas/user.schema';

@Injectable()
export class StatisticService {
  constructor(
    @InjectModel(User.name) private userSchema: Model<User>,
    @InjectModel(Category.name) private categorySchema: Model<Category>,
    @InjectModel(Product.name) private productSchema: Model<Product>,
    @InjectModel(Order.name) private orderSchema: Model<Order>,
  ) {}

  async userOperation(data: any) {
    const user = new this.userSchema(data);
    await user.save();
  }

  async categoryOperation(data: any) {
    const category = new this.categorySchema(data);
    await category.save();
  }

  async productOperation(data: any) {
    const product = new this.productSchema(data);
    await product.save();
  }

  async orderOperation(data: any) {
    const order = new this.orderSchema(data);
    await order.save();
  }

  async getUsers() {
    const users = await this.userSchema.find();
    return users;
  }

  async getOrders() {
    const order = await this.orderSchema.find();
    return order;
  }

  async getProducts() {
    const products = await this.productSchema.find();
    return products;
  }

  async getCategories() {
    const categories = await this.categorySchema.find();
    return categories;
  }

  async getInfo() {
    const category = (await this.getCategories()).length;
    const user = (await this.getUsers()).length;
    const product = (await this.getProducts()).length;
    const order = (await this.getOrders()).length;

    return {
      category,
      user,
      product,
      order,
    };
  }
}
