import type { Meta, StoryObj } from '@storybook/react';
import { Button } from './button';
const meta = {
  title: 'MY UI BUTTON/Button',
  component: Button,
  parameters: { 
    layout: 'centered',
  },
  tags: ['autodocs'],
  args: { variant: "outline", children: "Button" } 
} satisfies Meta<typeof Button>;

export default meta;
type Story = StoryObj<typeof meta>;

export const Default: Story = {args: {variant: "default"}};
export const Primary: Story = {args: {variant: "primary"}};
export const Outline: Story = {args: {variant: "outline"}};