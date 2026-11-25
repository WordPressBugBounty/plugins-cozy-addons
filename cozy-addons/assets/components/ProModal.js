import { __, sprintf } from "@wordpress/i18n";
import { Modal, Button } from "@wordpress/components";

/**
 * Offers Pro without touching the block, unlike UpsellModal which removes it.
 *
 * @param {Object}   props
 * @param {Object}   props.variation Feature or form type, with a title and a description.
 * @param {Function} props.onClose   Closes the modal.
 */
export const ProModal = ({ variation, onClose }) => (
	<Modal
		title={sprintf(
			/* translators: %s: form type or feature, e.g. "Product Enquiry" */
			__("%s is available in Pro", "cozy-addons"),
			variation.title,
		)}
		onRequestClose={onClose}
		size="medium"
	>
		<p>{variation.description}</p>
		<p>
			{__("Upgrade to Cozy Blocks Pro to use this feature.", "cozy-addons")}
		</p>
		<div style={{ textAlign: "right" }}>
			<Button variant="tertiary" onClick={onClose} style={{ marginRight: "12px" }}>
				{__("Not now", "cozy-addons")}
			</Button>
			<Button
				href="https://cozythemes.com/pricing-and-plans"
				target="_blank"
				variant="primary"
			>
				{__("Upgrade to Pro", "cozy-addons")}
			</Button>
		</div>
	</Modal>
);
