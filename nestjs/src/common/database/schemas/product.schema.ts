import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';

@Schema()
export class Product {
  @Prop()
  original_id: number;

  @Prop()
  title: string;

  @Prop()
  count: number;

  @Prop()
  price: number;

  @Prop()
  category: string;

  @Prop()
  description: string;
}

export const ProductSchema = SchemaFactory.createForClass(Product);
