import React from "react";
import { Head } from "@inertiajs/inertia-react";

const Header = ({
  title = "Test Title",
  description = "Test Web Description",
}) => {
  return (
    <Head>
      <title>{title}</title>
      <meta name="description" content={description} />
    </Head>
  );
};

export default Header;
