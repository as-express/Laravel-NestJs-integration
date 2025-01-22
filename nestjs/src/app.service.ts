import { Injectable } from '@nestjs/common';
import { StatisticService } from './statistic/statistic.service';

@Injectable()
export class AppService {
  constructor(private statisticService: StatisticService) {}

  async getInfo() {
    const res = await this.statisticService.getInfo();
    return res;
  }
}
