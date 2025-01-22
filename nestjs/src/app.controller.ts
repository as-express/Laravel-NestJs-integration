import { Controller, Get, Render } from '@nestjs/common';
import { AppService } from './app.service';

@Controller()
export class AppController {
  constructor(private appService: AppService) {}

  @Get()
  @Render('home')
  async home() {
    const info = await this.appService.getInfo();
    return { info };
  }
}
