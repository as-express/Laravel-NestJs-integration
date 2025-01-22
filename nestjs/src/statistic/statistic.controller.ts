import { Controller, Get, Render } from '@nestjs/common';
import { StatisticService } from './statistic.service';
import { MessagePattern } from '@nestjs/microservices';

@Controller('statistic')
export class StatisticController {
  constructor(private readonly statisticService: StatisticService) {}

  @Get('category')
  @Render('category')
  async category() {
    const categories = await this.statisticService.getCategories();
    return { categories };
  }

  @Get('order')
  @Render('order')
  async order() {
    const orders = await this.statisticService.getOrders();
    return { orders };
  }

  @Get('product')
  @Render('product')
  async product() {
    const products = await this.statisticService.getProducts();
    return { products };
  }

  @Get('user')
  @Render('user')
  async user() {
    const users = await this.statisticService.getUsers();
    return { users };
  }

  @MessagePattern('user_created')
  async handleUser(data: any) {
    console.log(data);
    const obj = {
      original_id: data.id,
      username: data.name,
      email: data.email,
    };

    console.log(obj);
    return await this.statisticService.userOperation(obj);
  }

  @MessagePattern('category_created')
  async handleCategory(data: any) {
    console.log(data);
    const obj = {
      original_id: data.id,
      title: data.title,
      product_count: data.product_count,
    };

    console.log(obj);
    return await this.statisticService.categoryOperation(obj);
  }

  @MessagePattern('product_created')
  async handleProduct(data: any) {
    console.log(data);
    const obj = {
      original_id: data.id,
      title: data.title,
      count: data.count,
      price: data.price,
      category: data.category_id,
      description: data.description,
    };

    console.log(obj);
    return await this.statisticService.productOperation(obj);
  }

  @MessagePattern('order_created')
  async handleOrder(data: any) {
    console.log(data);
    const obj = {
      original_id: data.id,
      user: data.user_id,
      products: data.products,
      price: data.totalPrice,
      status: data.status,
      address: data.address,
    };

    console.log(obj);
    return await this.statisticService.orderOperation(obj);
  }
}
