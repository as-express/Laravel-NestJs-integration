import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';

@Schema()
export class Category {
  @Prop()
  original_id: number;

  @Prop()
  title: string;

  @Prop()
  product_count: number;
}

export const CategorySchema = SchemaFactory.createForClass(Category);
