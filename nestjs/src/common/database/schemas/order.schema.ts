import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';

@Schema()
export class Order {
  @Prop()
  original_id: number;

  @Prop()
  user: string;

  @Prop()
  orders: string[];

  @Prop()
  status: string;

  @Prop()
  price: number;

  @Prop()
  address: string;
}

export const OrderSchema = SchemaFactory.createForClass(Order);
