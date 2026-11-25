import { __ } from "@wordpress/i18n";

import { isPremium } from "../../src/index.js";
import { PremiumLink } from "./PremiumLink.js";

/**
 * Panel title with a "PRO" pill on free sites.
 *
 * @param {string} title Panel title.
 */
export const proTitle = (title) =>
	isPremium ? (
		title
	) : (
		<>
			{title}
			<span className="cozy-form-pro-pill">{__("Pro", "cozy-addons")}</span>
		</>
	);

/**
 * Body of a locked panel on free sites: what the feature does and the upgrade link.
 *
 * @param {Object} props
 * @param {string} props.children What the feature does.
 */
export const ProNotice = ({ children }) => (
	<>
		<p className="components-base-control__help">{children}</p>
		<PremiumLink />
	</>
);
