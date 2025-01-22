import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';

@Schema()
export class User {
  @Prop()
  original_id: number;

  @Prop()
  username: string;

  @Prop()
  email: string;

  @Prop({ default: new Date() })
  createdAt: Date;
}

export const UserSchema = SchemaFactory.createForClass(User);
