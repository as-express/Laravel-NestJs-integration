import { Module, OnApplicationBootstrap } from '@nestjs/common';
import { StatisticModule } from './statistic/statistic.module';
import { InjectModel, MongooseModule } from '@nestjs/mongoose';
import {
  Statistic,
  StatisticSchema,
} from './common/database/schemas/statistic';
import { Model } from 'mongoose';
import { AppController } from './app.controller';
import { AppService } from './app.service';

@Module({
  imports: [
    StatisticModule,
    MongooseModule.forRoot(
      'mongodb+srv://expressaset:aset@astify.p7ma5.mongodb.net/Astify?retryWrites=true&w=majority&appName=Astify',
    ),
    MongooseModule.forFeature([
      { name: Statistic.name, schema: StatisticSchema },
    ]),
  ],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule implements OnApplicationBootstrap {
  constructor(
    @InjectModel(Statistic.name) private statistic: Model<Statistic>,
  ) {}

  onApplicationBootstrap() {}

  async static() {
    const isHave = await this.statistic.find();
    if (isHave.length > 0) {
      console.log('Statistic have in db');
    }

    const stats = new this.statistic({});
    await stats.save();

    console.log('Statistic is created');
  }
}
