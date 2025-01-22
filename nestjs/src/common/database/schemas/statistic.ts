import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';

@Schema()
export class Statistic {
  @Prop({ default: 0 })
  users: number;

  @Prop({ default: 0 })
  categories: number;

  @Prop({ default: 0 })
  products: number;

  @Prop({ default: 0 })
  orders: number;

  @Prop({ default: 0 })
  avg_requests: number;
}

export const StatisticSchema = SchemaFactory.createForClass(Statistic);
