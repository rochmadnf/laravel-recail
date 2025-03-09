import { Html, Text } from "@react-email/components";
import * as React from "react";

export default function Email({ user }) {
  return (
    <Html>
      <Text>Hello from react email, {user.name}</Text>
    </Html>
  );
}
